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

    public function pengelolaDashboard()
    {
        $totalMahasiswa = Mahasiswa::count();
        $totalPengajuanSertifikat = PengajuanSertifikat::count();
        $totalPengajuanSKPI = PengajuanSKPI::count();

        // Permintaan pengajuan terbaru (5 data terakhir)
        $pengajuanTerbaru = PengajuanSertifikat::with(['mahasiswa.prodi', 'mahasiswa.prodi.fakultas', 'sertifikat'])
            ->latest()
            ->take(5)
            ->get();

        // Top 5 mahasiswa dengan poin tertinggi
        $top5Mahasiswa = Mahasiswa::orderBy('poin_kredit', 'desc')
            ->with('prodi.fakultas')
            ->take(5)
            ->get();

        return view('pengelola.dashboard', compact(
            'totalMahasiswa',
            'totalPengajuanSertifikat',
            'totalPengajuanSKPI',
            'pengajuanTerbaru',
            'top5Mahasiswa'
        ));
    }

    public function mahasiswaDashboard()
    {
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;

        // Total poin dan total approved
        $totalPoin = $mahasiswa->poin_kredit ?? 0;

        // Total pengajuan yang disetujui
        $totalApprovedSertifikat = PengajuanSertifikat::where('nim', $mahasiswa->nim)
            ->where('status', 'disetujui')
            ->count();

        $totalApprovedSKPI = PengajuanSKPI::where('nim', $mahasiswa->nim)
            ->where('status', 'disetujui')
            ->count();

        $totalApproved = $totalApprovedSertifikat + $totalApprovedSKPI;

        // Status pengajuan terbaru (5 pengajuan terakhir dari sertifikat dan SKPI)
        $pengajuanSertifikat = PengajuanSertifikat::where('nim', $mahasiswa->nim)
            ->latest()
            ->get();

        $pengajuanSKPI = PengajuanSKPI::where('nim', $mahasiswa->nim)
            ->latest()
            ->get();

        // Merge dan sort by date
        $statusPengajuan = collect();
        foreach ($pengajuanSertifikat as $p) {
            $statusPengajuan->push((object) [
                'jenis' => 'Sertifikat',
                'tanggal' => $p->tgl_pengajuan_sertifikat,
                'status' => $p->status
            ]);
        }
        foreach ($pengajuanSKPI as $p) {
            $statusPengajuan->push((object) [
                'jenis' => 'SKPI',
                'tanggal' => $p->tgl_pengajuan_skpi,
                'status' => $p->status
            ]);
        }
        $statusPengajuan = $statusPengajuan->sortByDesc('tanggal')->take(5);

        // Tentukan maksimal poin berdasarkan status beasiswa
        $maxPoin = $mahasiswa->beasiswa ? 150 : 100;

        return view('mahasiswa.dashboard', compact(
            'totalPoin',
            'totalApproved',
            'statusPengajuan',
            'maxPoin',
            'mahasiswa'
        ));
    }
}
