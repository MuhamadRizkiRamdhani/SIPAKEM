<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SubKategoriController;
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
use App\Models\SubKategori;
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

        // Admin CRUD Routes
        Route::resource('admin', \App\Http\Controllers\AdminController::class)->names([
            'index' => 'admin.index',
            'create' => 'admin.create',
            'store' => 'admin.store',
            'show' => 'admin.show',
            'edit' => 'admin.edit',
            'update' => 'admin.update',
            'destroy' => 'admin.destroy'
        ])->parameters(['admin' => 'id_admin']);

        // User CRUD Routes
        Route::resource('pengguna', UserController::class)->names([
            'index' => 'pengguna.index',
            'create' => 'pengguna.create',
            'store' => 'pengguna.store',
            'show' => 'pengguna.show',
            'edit' => 'pengguna.edit',
            'update' => 'pengguna.update',
            'destroy' => 'pengguna.destroy'
        ])->parameters(['pengguna' => 'id_user']);

        // Fakultas CRUD Routes
        Route::resource('fakultas', FakultasController::class)->names([
            'index' => 'fakultas.index',
            'create' => 'fakultas.create',
            'store' => 'fakultas.store',
            'show' => 'fakultas.show',
            'edit' => 'fakultas.edit',
            'update' => 'fakultas.update',
            'destroy' => 'fakultas.destroy'
        ])->parameters(['fakultas' => 'id_fakultas']);

        // Prodi CRUD Routes
        Route::resource('prodi', ProdiController::class)->names([
            'index' => 'prodi.index',
            'create' => 'prodi.create',
            'store' => 'prodi.store',
            'show' => 'prodi.show',
            'edit' => 'prodi.edit',
            'update' => 'prodi.update',
            'destroy' => 'prodi.destroy'
        ])->parameters(['prodi' => 'id_prodi']);

        // Kategori CRUD Routes
        Route::resource('kategori', KategoriController::class)->names([
            'index' => 'kategori.index',
            'create' => 'kategori.create',
            'store' => 'kategori.store',
            'show' => 'kategori.show',
            'edit' => 'kategori.edit',
            'update' => 'kategori.update',
            'destroy' => 'kategori.destroy'
        ])->parameters(['kategori' => 'id_kategori']);

        //Sub Kategori CRUD
        Route::resource('sub-kategori', SubKategoriController::class)->names([
            'index' => 'sub-kategori.index',
            'create' => 'sub-kategori.create',
            'store' => 'sub-kategori.store',
            'show' => 'sub-kategori.show',
            'edit' => 'sub-kategori.edit',
            'update' => 'sub-kategori.update',
            'destroy' => 'sub-kategori.destroy'
        ])->parameters(['sub-kategori' => 'id_sub-kategori']);

        //Level CRUD
        Route::resource('level', LevelController::class)->names([
            'index' => 'level.index',
            'create' => 'level.create',
            'store' => 'level.store',
            'show' => 'level.show',
            'edit' => 'level.edit',
            'update' => 'level.update',
            'destroy' => 'level.destroy'
        ]);

        Route::get('/mahasiswa/export-pdf', [MahasiswaController::class, 'exportPdf'])
            ->name('mahasiswa.exportPdf');

        // Mahasiswa CRUD Routes
        Route::resource('mahasiswa', MahasiswaController::class)->names([
            'index' => 'mahasiswa.index',
            'create' => 'mahasiswa.create',
            'store' => 'mahasiswa.store',
            'show' => 'mahasiswa.show',
            'edit' => 'mahasiswa.edit',
            'update' => 'mahasiswa.update',
            'destroy' => 'mahasiswa.destroy'
        ])->parameters(['mahasiswa' => 'nim']);

        // Pengelola Export PDF
        Route::get('/pengelola/export-pdf', [PengelolaController::class, 'exportPdf'])
            ->name('pengelola.exportPdf');

        // Tambahkan di sini ↓
        Route::post('/mahasiswa/import', [MahasiswaController::class, 'import'])
            ->name('mahasiswa.import');

        // Pengelola CRUD Routes
        Route::resource('pengelola', PengelolaController::class)->names([
            'index' => 'pengelola.index',
            'create' => 'pengelola.create',
            'store' => 'pengelola.store',
            'show' => 'pengelola.show',
            'edit' => 'pengelola.edit',
            'update' => 'pengelola.update',
            'destroy' => 'pengelola.destroy'
        ])->parameters(['pengelola' => 'id_pengelola']);

        Route::get('/data-pengajuan-sertifikat', [PengajuanSertifikatController::class, 'index'])->name('data-pengajuan-sertifikat');

        Route::resource('pengajuan-sertifikat', PengajuanSertifikatController::class);

        Route::get('/data-pengajuan-skpi', [PengajuanSKPIController::class, 'index'])
            ->name('data-pengajuan-skpi');

        Route::resource('pengajuan-skpi', PengajuanSKPIController::class)
            ->parameters([
                'pengajuan-skpi' => 'pengajuanSKPI'
            ]);

        Route::resource('poin', PointRulesController::class)
            ->names([
                'index' => 'poin.index',
                'create' => 'poin.create',
                'store' => 'poin.store',
                'show' => 'poin.show',
                'edit' => 'poin.edit',
                'update' => 'poin.update',
                'destroy' => 'poin.destroy'
            ])
            ->parameters([
                'poin' => 'pointRules'
            ]);
    });


// ==================== PENGELOLA ====================
Route::prefix('pengelola')
    ->name('pengelola.')
    ->middleware(['auth', 'role:pengelola'])
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'pengelolaDashboard'])->name('dashboard');

        Route::get('/mahasiswa/export-pdf', [MahasiswaController::class, 'exportPdf'])
            ->name('mahasiswa.exportPdf');

        Route::resource('mahasiswa', MahasiswaController::class)->names([
            'index' => 'mahasiswa.index',
            'create' => 'mahasiswa.create',
            'store' => 'mahasiswa.store',
            'show' => 'mahasiswa.show',
            'edit' => 'mahasiswa.edit',
            'update' => 'mahasiswa.update',
            'destroy' => 'mahasiswa.destroy'
        ])->parameters(['mahasiswa' => 'nim']);

        Route::get('/data-pengajuan-sertifikat', [PengajuanSertifikatController::class, 'index'])
            ->name('data-pengajuan-sertifikat');

        Route::resource('pengajuan-sertifikat', PengajuanSertifikatController::class);

        Route::get('/data-pengajuan-skpi', [PengajuanSKPIController::class, 'index'])
            ->name('data-pengajuan-skpi');

        Route::resource('pengajuan-skpi', PengajuanSKPIController::class)
            ->parameters([
                'pengajuan-skpi' => 'pengajuanSKPI'
            ]);
    });


// ==================== MAHASISWA ====================
Route::prefix('mahasiswa')
    ->name('mahasiswa.')
    ->middleware(['auth', 'role:mahasiswa'])
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'mahasiswaDashboard'])->name('dashboard');

        Route::get('/riwayat-pengajuan', [PengajuanController::class, 'riwayat'])
            ->name('riwayat-pengajuan');

        Route::get('/riwayat-pengajuan/detail-sertifikat/{id_pengajuan}', [PengajuanController::class, 'detailSertifikat'])
            ->name('detail-sertifikat');

        Route::get('/riwayat-pengajuan/print-skpi/{id_pengajuan_skpi}', [PengajuanController::class, 'printSKPI'])
            ->name('print-skpi');

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