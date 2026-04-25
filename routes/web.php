<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// ==================== AUTH ROUTES ====================

// Menampilkan halaman login
Route::get('/', [AuthController::class, 'showLogin'])->name('login');

// API routes untuk login dan register
Route::post('/api/login', [AuthController::class, 'login']);
Route::post('/api/register', [AuthController::class, 'register']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ==================== ADMIN ROUTES ====================
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard-admin');

    Route::get('/data-mahasiswa', function () {
        return view('admin.data-mahasiswa');
    })->name('data-mahasiswa');

    Route::get('/data-pengelola', function () {
        return view('admin.data-pengelola');
    })->name('data-pengelola');

    Route::get('/data-kategori', function () {
        return view('admin.data-kategori');
    })->name('data-kategori');

    Route::get('/data-fakultas', function () {
        return view('admin.data-fakultas');
    })->name('data-fakultas');
});

// ==================== PENGELOLA ROUTES ====================
Route::prefix('pengelola')->middleware(['auth', 'role:pengelola'])->group(function () {
    Route::get('/dashboard', function () {
        return view('pengelola.dashboard');
    })->name('dashboard-pengelola');

    Route::get('/data-pengajuan', function () {
        return view('pengelola.data-pengajuan');
    })->name('data-pengajuan');
});

// ==================== MAHASISWA ROUTES ====================
Route::prefix('mahasiswa')->middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/dashboard', function () {
        return view('mahasiswa.dashboard');
    })->name('dashboard-mahasiswa');
});
