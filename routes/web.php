<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopsisController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\AlternativeController;

// Mengalihkan alamat utama otomatis ke halaman login sesuai Use Case Bab IV
Route::get('/', function () {
    return redirect()->route('login');
})->name('public.portal');

// Gerbang Autentikasi Admin / Petugas SPPG
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// JALUR PROTEKSI INTERNAL (Wajib Login untuk Mengakses Fitur SPK)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [TopsisController::class, 'index'])->name('admin.dashboard');
    Route::get('/ranking-spk', [TopsisController::class, 'calculate'])->name('admin.result');
    Route::get('/rekomendasi-menu', [TopsisController::class, 'recommendation'])->name('admin.recommendation');

    // AKSES KHUSUS ADMIN (CRUD Kriteria & Alternatif)
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('criterias', CriteriaController::class);
        Route::resource('alternatives', AlternativeController::class);
        // Admin dapat menambah pengguna baru dari dashboard
        Route::post('/users', [AuthController::class, 'createUser'])->name('admin.users.store');
        // Admin profile management
        Route::get('/profile', [AuthController::class, 'editProfile'])->name('admin.profile.edit');
        Route::put('/profile', [AuthController::class, 'updateProfile'])->name('admin.profile.update');
    });
});

// Fallback jika ada user mengetik URL acak yang tidak terdaftar
Route::fallback(function () {
    return redirect()->route('login');
});