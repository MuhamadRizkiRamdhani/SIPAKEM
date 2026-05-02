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
use App\Http\Controllers\PengajuanController;
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

        Route::get('/dashboard', [DashboardController::class, 'pengelolaDashboard'])->name('dashboard');

        Route::get('/data-mahasiswa', [MahasiswaController::class, 'index'])->name('data-mahasiswa');

        Route::get('/data-pengajuan-sertifikat', [PengajuanSertifikatController::class, 'index'])->name('data-pengajuan-sertifikat');

        Route::get('/data-pengajuan-skpi', [PengajuanSKPIController::class, 'index'])->name('data-pengajuan-skpi');

    });


// ==================== MAHASISWA ====================
Route::prefix('mahasiswa')
    ->name('mahasiswa.')
    ->middleware(['auth', 'role:mahasiswa'])
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'mahasiswaDashboard'])->name('dashboard');

        Route::get('/riwayat-pengajuan', [PengajuanController::class, 'riwayat'])
            ->name('riwayat-pengajuan');

        Route::get('/pengajuan-sertifikat', [PengajuanController::class, 'formSertifikat'])->name('pengajuan-sertifikat');

        Route::post('/pengajuan-sertifikat', [PengajuanController::class, 'storeSertifikat'])->name('pengajuan-sertifikat.store');

        Route::get('/pengajuan-skpi', [PengajuanController::class, 'formSKPI'])->name('pengajuan-skpi');

        Route::post('/pengajuan-skpi', [PengajuanController::class, 'storeSKPI'])->name('pengajuan-skpi.store');
    });

// ==================== AJAX ENDPOINTS ====================
Route::middleware(['auth'])->group(function () {
    Route::get('/api/sub-kategori/{id_kategori}', [PengajuanController::class, 'getSubKategori']);
    Route::get('/api/level', [PengajuanController::class, 'getLevel']);
});