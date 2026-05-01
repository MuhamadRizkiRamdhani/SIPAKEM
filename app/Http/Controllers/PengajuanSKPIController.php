<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSKPI;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class PengajuanSKPIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengajuanSKPIs = PengajuanSKPI::with('mahasiswa')->get();

        $role = auth()->user()->role;

        return view("$role.pengajuan.skpi", compact('pengajuanSKPIs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mahasiswas = Mahasiswa::all();
        return view('pengajuan-skpi.create', compact('mahasiswas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|exists:mahasiswa,nim',
            'status' => 'required|in:pending,diproses,diterima,ditolak',
            'tgl_pengajuan_skpi' => 'required|date'
        ]);

        PengajuanSKPI::create($validated);

        return redirect()->route('pengajuan-skpi.index')->with('success', 'Pengajuan SKPI berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(PengajuanSKPI $pengajuanSKPI)
    {
        return view('pengajuan-skpi.show', compact('pengajuanSKPI'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengajuanSKPI $pengajuanSKPI)
    {
        $mahasiswas = Mahasiswa::all();
        return view('pengajuan-skpi.edit', compact('pengajuanSKPI', 'mahasiswas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PengajuanSKPI $pengajuanSKPI)
    {
        $validated = $request->validate([
            'nim' => 'required|exists:mahasiswa,nim',
            'status' => 'required|in:pending,diproses,diterima,ditolak',
            'tgl_pengajuan_skpi' => 'required|date'
        ]);

        $pengajuanSKPI->update($validated);

        return redirect()->route('pengajuan-skpi.index')->with('success', 'Pengajuan SKPI berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengajuanSKPI $pengajuanSKPI)
    {
        $pengajuanSKPI->delete();

        return redirect()->route('pengajuan-skpi.index')->with('success', 'Pengajuan SKPI berhasil dihapus');
    }
}
