<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSertifikat;
use App\Models\Mahasiswa;
use App\Models\Sertifikat;
use App\Models\Pengelola;
use App\Models\PointRules;
use Illuminate\Http\Request;

class PengajuanSertifikatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengajuanSertifikats = PengajuanSertifikat::with([
            'mahasiswa',
            'sertifikat',
            'pengelola',
            'pointRules'
        ])->get();
        return view('pengajuan-sertifikat.index', compact('pengajuanSertifikats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mahasiswas = Mahasiswa::all();
        $sertifikats = Sertifikat::all();
        $pengelolas = Pengelola::all();
        $pointRules = PointRules::all();
        return view('pengajuan-sertifikat.create', compact('mahasiswas', 'sertifikats', 'pengelolas', 'pointRules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|exists:mahasiswa,nim',
            'id_sertifikat' => 'required|exists:sertifikat,id_sertifikat',
            'status' => 'required|in:pending,diproses,diterima,ditolak',
            'tgl_pengajuan_sertifikat' => 'required|date',
            'id_pengelola' => 'nullable|exists:pengelola,id_pengelola',
            'feedback' => 'nullable|string',
            'id_rules' => 'nullable|exists:point_rules,id_rules',
            'poin_akhir' => 'nullable|integer|min:0'
        ]);

        PengajuanSertifikat::create($validated);

        return redirect()->route('pengajuan-sertifikat.index')->with('success', 'Pengajuan Sertifikat berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(PengajuanSertifikat $pengajuanSertifikat)
    {
        return view('pengajuan-sertifikat.show', compact('pengajuanSertifikat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengajuanSertifikat $pengajuanSertifikat)
    {
        $mahasiswas = Mahasiswa::all();
        $sertifikats = Sertifikat::all();
        $pengelolas = Pengelola::all();
        $pointRules = PointRules::all();
        return view('pengajuan-sertifikat.edit', compact('pengajuanSertifikat', 'mahasiswas', 'sertifikats', 'pengelolas', 'pointRules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PengajuanSertifikat $pengajuanSertifikat)
    {
        $validated = $request->validate([
            'nim' => 'required|exists:mahasiswa,nim',
            'id_sertifikat' => 'required|exists:sertifikat,id_sertifikat',
            'status' => 'required|in:pending,diproses,diterima,ditolak',
            'tgl_pengajuan_sertifikat' => 'required|date',
            'id_pengelola' => 'nullable|exists:pengelola,id_pengelola',
            'feedback' => 'nullable|string',
            'id_rules' => 'nullable|exists:point_rules,id_rules',
            'poin_akhir' => 'nullable|integer|min:0'
        ]);

        $pengajuanSertifikat->update($validated);

        return redirect()->route('pengajuan-sertifikat.index')->with('success', 'Pengajuan Sertifikat berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengajuanSertifikat $pengajuanSertifikat)
    {
        $pengajuanSertifikat->delete();

        return redirect()->route('pengajuan-sertifikat.index')->with('success', 'Pengajuan Sertifikat berhasil dihapus');
    }
}
