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
        $query = PengajuanSKPI::with([
            'mahasiswa.prodi.fakultas'
        ]);

        // SEARCH
        if (request('search')) {
            $query->where(function ($q) {
                $q->where('nim', 'like', '%' . request('search') . '%')
                    ->orWhereHas('mahasiswa', function ($q2) {
                        $q2->where('nama_mhs', 'like', '%' . request('search') . '%');
                    });
            });
        }

        // FILTER STATUS
        if (request('status')) {
            $query->where('status', request('status'));
        }

        $pengajuanSKPIs = $query->latest()->paginate(6);

        $role = auth()->user()->role;

        return view("$role.pengajuan.skpi", compact(
            'pengajuanSKPIs',
            'role'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pengajuan = PengajuanSKPI::with([
            'mahasiswa.prodi.fakultas'
        ])->findOrFail($id);

        $role = auth()->user()->role;

        return view("$role.pengajuan.detail-skpi", compact(
            'pengajuan'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PengajuanSKPI $pengajuanSKPI)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,diterima,ditolak',
        ]);

        $pengajuanSKPI->update([
            'status' => $request->status,
        ]);

        $role = auth()->user()->role;

        return redirect()->route("$role.pengajuan-skpi.index")
            ->with('success', 'Status berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengajuanSKPI $pengajuanSKPI)
    {
        $pengajuanSKPI->delete();

        $role = auth()->user()->role;

        return redirect()->route("$role.pengajuan-skpi.index")
            ->with('success', 'Pengajuan SKPI berhasil dihapus');
    }
}