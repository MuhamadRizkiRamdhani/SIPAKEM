<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSertifikat;
use App\Models\Mahasiswa;
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
        $query = PengajuanSertifikat::with([
            'mahasiswa',
            'pengelola',
            'pointRules'
        ]);

        // SEARCH (nama / nim / sertifikat)
        if (request('search')) {
            $query->where(function ($q) {
                $q->where('nim', 'like', '%' . request('search') . '%')
                    ->orWhere('nama_sertifikat', 'like', '%' . request('search') . '%')
                    ->orWhereHas('mahasiswa', function ($q2) {
                        $q2->where('nama_mhs', 'like', '%' . request('search') . '%');
                    });
            });
        }

        // FILTER STATUS
        if (request('status')) {
            $query->where('status', request('status'));
        }

        $pengajuanSertifikats = $query->latest()->paginate(6);

        $role = auth()->user()->role;

        return view("$role.pengajuan.sertifikat", compact('pengajuanSertifikats', 'role'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mahasiswas = Mahasiswa::all();
        $pengelolas = Pengelola::all();
        $pointRules = PointRules::all();
        return view('pengajuan-sertifikat.create', compact('mahasiswas', 'pengelolas', 'pointRules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|exists:mahasiswa,nim',
            'status' => 'required|in:pending,diproses,diterima,ditolak',
            'tgl_pengajuan_sertifikat' => 'required|date',
            'feedback' => 'nullable|string',
            'id_rules' => 'nullable|exists:point_rules,id_rules',
            'poin_akhir' => 'nullable|integer|min:0'
        ]);

        PengajuanSertifikat::create($validated);

        return redirect()->route('admin.pengajuan-sertifikat.index')
            ->with('success', 'Pengajuan Sertifikat berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pengajuan = PengajuanSertifikat::with([
            'mahasiswa',
            'pengelola',
            'pointRules',
            'kategori',
            'subKategori',
            'level'
        ])->findOrFail($id);

        $role = auth()->user()->role;

        return view("$role.pengajuan.detail-sertifikat", compact('pengajuan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengajuanSertifikat $pengajuanSertifikat)
    {
        $mahasiswas = Mahasiswa::all();
        $pengelolas = Pengelola::all();
        $pointRules = PointRules::all();
        return view('pengajuan-sertifikat.edit', compact('pengajuanSertifikat', 'mahasiswas', 'pengelolas', 'pointRules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PengajuanSertifikat $pengajuanSertifikat)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,diterima,ditolak',
            'feedback' => 'nullable|string|max:255|regex:/^[a-zA-Z0-9\s.,!?-]*$/',
        ]);

        // SIMPAN STATUS LAMA
        $statusLama = $pengajuanSertifikat->status;

        // UPDATE DATA
        $pengajuanSertifikat->update([
            'status' => $request->status,
            'feedback' => $request->feedback,
            'id_pengelola' => Pengelola::where('id_user', auth()->id())->value('id_pengelola')
        ]);

        // TAMBAH POIN HANYA JIKA BARU DITERIMA & ADA POIN
        if (
            $statusLama !== 'diterima' &&
            $request->status === 'diterima' &&
            $pengajuanSertifikat->poin_akhir
        ) {
            $mahasiswa = $pengajuanSertifikat->mahasiswa;

            if ($mahasiswa) {
                $mahasiswa->increment('poin_kredit', $pengajuanSertifikat->poin_akhir);
            }
        }

        $role = auth()->user()->role;

        return redirect()->route("$role.pengajuan-sertifikat.index")
            ->with('success', 'Status berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengajuanSertifikat $pengajuanSertifikat)
    {
        $pengajuanSertifikat->delete();

        $role = auth()->user()->role;

        return redirect()->route("$role.pengajuan-sertifikat.index")
            ->with('success', 'Pengajuan Sertifikat berhasil dihapus');
    }
}
