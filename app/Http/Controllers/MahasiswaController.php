<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Prodi;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::with(['user', 'prodi.fakultas'])->get();
        return view("admin.mahasiswa.index", compact('mahasiswas'));
    }

    public function create()
    {
        $users = User::where('role', 'mahasiswa')->doesntHave('mahasiswa')->get();
        $prodis = Prodi::all();
        return view('admin.mahasiswa.create', compact('users', 'prodis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|string|max:20|unique:mahasiswa,nim',
            'nama_mhs' => 'required|string|max:255',
            'id_user' => 'required|exists:users,id_user',
            'id_prodi' => 'required|exists:prodi,id_prodi',
            'poin_kredit' => 'required|integer|min:0',
            'tahun_angkatan' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
            'beasiswa' => 'required|in:0,1'
        ]);

        // Konversi beasiswa ke boolean untuk database
        $validated['beasiswa'] = (bool) $validated['beasiswa'];

        Mahasiswa::create($validated);

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil ditambahkan!');
    }

    public function show($id)
    {
        $mahasiswa = Mahasiswa::with(['user', 'prodi.fakultas'])->findOrFail($id);
        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }

    public function edit($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        // Untuk edit, tampilkan semua user mahasiswa termasuk yang sudah dipakai
        $users = User::where('role', 'mahasiswa')->get();
        $prodis = Prodi::all();
        return view('admin.mahasiswa.edit', compact('mahasiswa', 'users', 'prodis'));
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $validated = $request->validate([
            'nim' => 'required|string|max:20|unique:mahasiswa,nim,' . $id . ',nim',
            'nama_mhs' => 'required|string|max:255',
            'id_user' => 'required|exists:users,id_user',
            'id_prodi' => 'required|exists:prodi,id_prodi',
            'poin_kredit' => 'required|integer|min:0',
            'tahun_angkatan' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
            'beasiswa' => 'required|in:0,1'
        ]);

        // Konversi beasiswa ke boolean untuk database
        $validated['beasiswa'] = (bool) $validated['beasiswa'];

        $mahasiswa->update($validated);

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil diupdate!');
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $nama = $mahasiswa->nama_mhs;
        $mahasiswa->delete();

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', "Mahasiswa {$nama} berhasil dihapus!");
    }
}