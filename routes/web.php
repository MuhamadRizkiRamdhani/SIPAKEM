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
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::get('/data-pengguna', function () {
            return view('admin.data-pengguna');
        })->name('data-pengguna');

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

        Route::get('/data-pengajuan-sertifikat', function () {
            return view('admin.data-pengajuan-sertifikat');
        })->name('data-pengajuan-sertifikat');

        Route::get('/data-pengajuan-skpi', function () {
            return view('admin.data-pengajuan-skpi');
        })->name('data-pengajuan-skpi');
    });

// ==================== PENGELOLA ROUTES ====================
Route::prefix('pengelola')
    ->name('pengelola.')
    ->middleware(['auth', 'role:pengelola'])
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('pengelola.dashboard');
        })->name('dashboard');

        Route::get('/data-mahasiswa', function () {
            return view('pengelola.data-mahasiswa');
        })->name('data-mahasiswa');

        Route::get('/data-pengajuan-sertifikat', function () {
            return view('pengelola.data-pengajuan-sertifikat');
        })->name('data-pengajuan-sertifikat');

        Route::get('/data-pengajuan-skpi', function () {
            return view('pengelola.data-pengajuan-skpi');
        })->name('data-pengajuan-skpi');
    });

// ==================== MAHASISWA ROUTES ====================
Route::prefix('mahasiswa')
    ->name('mahasiswa.')
    ->middleware(['auth', 'role:mahasiswa'])
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('mahasiswa.dashboard');
        })->name('dashboard');

        Route::get('/riwayat-pengajuan', function () {
            return view('mahasiswa.riwayat-pengajuan');
        })->name('riwayat-pengajuan');

        Route::get('/pengajuan-sertifikat', function () {
            return view('mahasiswa.pengajuan-sertifikat');
        })->name('pengajuan-sertifikat');

        Route::get('/pengajuan-skpi', function () {
            return view('mahasiswa.pengajuan-skpi');
        })->name('pengajuan-skpi');
    });
