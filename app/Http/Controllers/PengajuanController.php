<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\SubKategori;
use App\Models\Level;
use App\Models\PengajuanSertifikat;
use App\Models\PengajuanSKPI;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    // ========================== SERTIFIKAT ==========================
    public function formSertifikat()
    {
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;
        $kategoris = Kategori::all();

        return view('mahasiswa.pengajuan.sertifikat', compact('mahasiswa', 'kategoris'));
    }

    // Get SubKategori by Kategori
    public function getSubKategori($id_kategori)
    {
        $subKategoris = SubKategori::where('id_kategori', $id_kategori)->get();
        return response()->json($subKategoris);
    }

    // Get Level
    public function getLevel()
    {
        $levels = Level::all();
        return response()->json($levels);
    }

    // Store Pengajuan Sertifikat
    public function storeSertifikat(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_sertifikat' => 'required|string|max:255',
                'id_kategori' => 'required|exists:kategori,id_kategori',
                'id_sub_kategori' => 'nullable|exists:sub_kategori,id_sub_kategori',
                'id_level' => 'nullable|exists:level,id_level',
                'file_sertifikat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
            ]);

            $user = auth()->user();
            $mahasiswa = $user->mahasiswa;

            // Upload file
            $filePath = null;
            if ($request->hasFile('file_sertifikat')) {
                $file = $request->file('file_sertifikat');
                $filename = time() . '_' . $mahasiswa->nim . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('pengajuan_sertifikat', $filename, 'public');
            }

            // Simpan ke pengajuan
            PengajuanSertifikat::create([
                'nim' => $mahasiswa->nim,
                'nama_sertifikat' => $validated['nama_sertifikat'],
                'file_path' => $filePath,
                'id_kategori' => $validated['id_kategori'],
                'id_sub_kategori' => $validated['id_sub_kategori'] ?? null,
                'id_level' => $validated['id_level'] ?? null,
                'tgl_pengajuan_sertifikat' => now()->toDateString(), // 🔥 fix
                'status' => 'pending'
            ]);

            return redirect()
                ->route('mahasiswa.riwayat-pengajuan')
                ->with('success', 'Pengajuan berhasil dikirim 🎉');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal mengajukan: ' . $e->getMessage())
                ->withInput();
        }
    }

    // ========================== SKPI ==========================
    public function formSKPI()
    {
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;

        // Tentukan maxPoin
        $maxPoin = $mahasiswa->beasiswa ? 150 : 100;
        $cukupPoin = $mahasiswa->poin_kredit >= $maxPoin;

        return view('mahasiswa.pengajuan.skpi', compact('mahasiswa', 'maxPoin', 'cukupPoin'));
    }

    // Store Pengajuan SKPI
    public function storeSKPI(Request $request)
    {
        try {
            $user = auth()->user();
            $mahasiswa = $user->mahasiswa;

            $maxPoin = $mahasiswa->beasiswa ? 150 : 100;

            if ($mahasiswa->poin_kredit < $maxPoin) {
                return redirect()->back()
                    ->with('error', 'Poin Anda belum cukup. Minimal ' . $maxPoin . ' poin diperlukan.')
                    ->withInput();
            }

            $pengajuan = new PengajuanSKPI();
            $pengajuan->nim = $mahasiswa->nim;
            $pengajuan->tgl_pengajuan_skpi = now()->toDateString();
            $pengajuan->status = 'pending';
            $pengajuan->save();

            return redirect()
                ->route('mahasiswa.riwayat-pengajuan')
                ->with('success', 'Pengajuan SKPI berhasil diajukan');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    // Riwayat
    public function riwayat()
    {
        $mahasiswa = auth()->user()->mahasiswa;

        $pengajuanSertifikat = \App\Models\PengajuanSertifikat::where('nim', $mahasiswa->nim)
            ->latest()
            ->get();

        $pengajuanSKPI = \App\Models\PengajuanSKPI::where('nim', $mahasiswa->nim)
            ->latest()
            ->get();

        return view('mahasiswa.riwayat.index', compact('pengajuanSertifikat', 'pengajuanSKPI'));
    }


}
