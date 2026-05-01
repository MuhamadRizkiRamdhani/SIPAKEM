<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Pengelola;
use App\Models\PengajuanSertifikat;
use App\Models\PengajuanSKPI;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMahasiswa = Mahasiswa::count();
        $totalPengelola = Pengelola::count();
        $totalPengajuanSertifikat = PengajuanSertifikat::count();
        $totalPengajuanSKPI = PengajuanSKPI::count();
        $totalPengajuan = $totalPengajuanSertifikat + $totalPengajuanSKPI;

        // Permintaan pengajuan terbaru (5 data terakhir)
        $pengajuanTerbaru = PengajuanSertifikat::with(['mahasiswa', 'sertifikat'])
            ->latest()
            ->take(5)
            ->get();

        // Top 5 mahasiswa dengan poin tertinggi
        $top5Mahasiswa = Mahasiswa::orderBy('poin_kredit', 'desc')
            ->with('prodi')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalMahasiswa',
            'totalPengelola',
            'totalPengajuan',
            'pengajuanTerbaru',
            'top5Mahasiswa'
        ));
    }
}
