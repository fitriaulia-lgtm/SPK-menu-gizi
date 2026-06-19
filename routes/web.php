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
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// JALUR PROTEKSI INTERNAL (Wajib Login untuk Mengakses Fitur SPK)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [TopsisController::class, 'index'])->name('admin.dashboard');
    Route::get('/ranking-spk', [TopsisController::class, 'calculate'])->name('admin.result');

    // AKSES KHUSUS ADMIN (CRUD Kriteria & Alternatif)
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('criterias', CriteriaController::class);
        Route::resource('alternatives', AlternativeController::class);
    });
});

// Fallback jika ada user mengetik URL acak yang tidak terdaftar
Route::fallback(function () {
    return redirect()->route('login');
});