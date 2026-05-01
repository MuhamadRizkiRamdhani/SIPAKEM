<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PengelolaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\PengajuanSertifikatController;
use App\Http\Controllers\PengajuanSKPIController;
use App\Http\Controllers\PointRulesController;
use Illuminate\Support\Facades\Route;

// ==================== AUTH ====================
Route::get('/', [AuthController::class, 'showLogin'])->name('login');

Route::post('/api/login', [AuthController::class, 'login']);
Route::post('/api/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// ==================== ADMIN ====================
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/data-pengguna', [UserController::class, 'index'])->name('data-pengguna');

        Route::get('/data-mahasiswa', [MahasiswaController::class, 'index'])->name('data-mahasiswa');

        Route::get('/data-pengelola', [PengelolaController::class, 'index'])->name('data-pengelola');

        Route::get('/data-kategori', [KategoriController::class, 'index'])->name('data-kategori');

        Route::get('/data-fakultas', [FakultasController::class, 'index'])->name('data-fakultas');

        Route::get('/data-prodi', [ProdiController::class, 'index'])->name('data-prodi');

        Route::get('/data-pengajuan-sertifikat', [PengajuanSertifikatController::class, 'index'])->name('data-pengajuan-sertifikat');

        Route::get('/data-pengajuan-skpi', [PengajuanSKPIController::class, 'index'])->name('data-pengajuan-skpi');

        Route::get('/data-poin', [PointRulesController::class, 'index'])->name('data-poin');
    });


// ==================== PENGELOLA ====================
Route::prefix('pengelola')
    ->name('pengelola.')
    ->middleware(['auth', 'role:pengelola'])
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('pengelola.dashboard');
        })->name('dashboard');

        Route::get('/data-mahasiswa', function () {
            return view('pengelola.mahasiswa.index');
        })->name('data-mahasiswa');

        Route::get('/data-pengajuan-sertifikat', function () {
            return view('pengelola.pengajuan.sertifikat');
        })->name('data-pengajuan-sertifikat');

        Route::get('/data-pengajuan-skpi', function () {
            return view('pengelola.pengajuan.skpi');
        })->name('data-pengajuan-skpi');

        Route::get('/data-poin', function () {
            return view('pengelola.poin.index');
        })->name('data-poin');
    });


// ==================== MAHASISWA ====================
Route::prefix('mahasiswa')
    ->name('mahasiswa.')
    ->middleware(['auth', 'role:mahasiswa'])
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('mahasiswa.dashboard');
        })->name('dashboard');

        Route::get('/riwayat-pengajuan', function () {
            return view('mahasiswa.riwayat.index');
        })->name('riwayat-pengajuan');

        Route::get('/pengajuan-sertifikat', function () {
            return view('mahasiswa.pengajuan.sertifikat');
        })->name('pengajuan-sertifikat');

        Route::get('/pengajuan-skpi', function () {
            return view('mahasiswa.pengajuan.skpi');
        })->name('pengajuan-skpi');
    });