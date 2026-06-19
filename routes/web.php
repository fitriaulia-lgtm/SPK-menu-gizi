<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopsisController;
use App\Http\Controllers\AuthController; // Pastikan memanggil AuthController

// Portal Utama (Publik)
Route::get('/', [TopsisController::class, 'index'])->name('public.portal');

// Gerbang Autentikasi Admin
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Jalur Proteksi Admin (Contoh menggunakan middleware auth bawaan)
Route::middleware(['auth'])->group(function () {
    // Taruh rute-rute internal admin di sini nanti (seperti kelola kriteria / alternatif)
});

// Fallback Redirect
Route::fallback(function () {
    return redirect()->route('public.portal');
});