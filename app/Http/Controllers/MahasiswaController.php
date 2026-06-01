<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Prodi;
use App\Models\Fakultas;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Imports\MahasiswaImport;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Mahasiswa::with(['user', 'prodi.fakultas']);
        $prodis = Prodi::all();
        $fakultas = Fakultas::all();

        // SEARCH (nama / NIM)
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_mhs', 'like', "%{$request->search}%")
                    ->orWhere('nim', 'like', "%{$request->search}%");
            });
        }

        // FILTER PRODI
        if ($request->prodi) {
            $query->where('id_prodi', $request->prodi);
        }


        // FILTER FAKULTAS
        if ($request->fakultas) {
            $query->whereHas('prodi', function ($q) use ($request) {
                $q->where('id_fakultas', $request->fakultas);
            });
        }

        // FILTER TAHUN ANGKATAN
        if ($request->tahun_angkatan) {
            $query->where('tahun_angkatan', $request->tahun_angkatan);
        }

        // SORT (opsional)
        if ($request->sort == 'latest') {
            $query->latest();
        }

        // PAGINATION
        $mahasiswas = $query->paginate(6)->withQueryString();

        $role = auth()->user()->role;

        return view("$role.mahasiswa.index", compact('mahasiswas', 'prodis', 'fakultas', 'role'));
    }

    public function importForm()
    {
        $role = auth()->user()->role;
        return view("$role.mahasiswa.import");
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240'
        ]);

        $import = new MahasiswaImport();
        Excel::import($import, $request->file('file'));

        $role = auth()->user()->role;

        $message = "Berhasil mengimport {$import->successCount} mahasiswa.";

        if (!empty($import->importErrors)) {
            $message .= ' Beberapa baris dilewati.';
            return redirect()->route("$role.mahasiswa.index")
                ->with('success', $message)
                ->with('import_errors', $import->importErrors);
        }

        return redirect()->route("$role.mahasiswa.index")
            ->with('success', $message);
    }

    public function create()
    {
        $users = User::where('role', 'mahasiswa')->doesntHave('mahasiswa')->get();
        $prodis = Prodi::all();

        $role = auth()->user()->role;

        return view("$role.mahasiswa.create", compact('users', 'prodis', 'role'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|numeric|digits_between:8,10|unique:mahasiswa,nim',
            'nama_mhs' => 'required|string|max:50|min:5|regex:/^[a-zA-Z\s]+$/',
            'id_user' => 'required|exists:users,id_user',
            'id_prodi' => 'required|exists:prodi,id_prodi',
            'poin_kredit' => 'required|integer|min:0',
            'tahun_angkatan' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
            'beasiswa' => 'required|in:0,1'
        ]);

        // Konversi beasiswa ke boolean untuk database
        $validated['beasiswa'] = (bool) $validated['beasiswa'];

        Mahasiswa::create($validated);

        $role = auth()->user()->role;

        return redirect()->route("$role.mahasiswa.index")
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

        $role = auth()->user()->role;

        return view("$role.mahasiswa.edit", compact('mahasiswa', 'users', 'prodis', 'role'));
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $validated = $request->validate([
            'nama_mhs' => 'required|string|max:50|min:5|regex:/^[a-zA-Z\s]+$/',
            'id_user' => 'required|exists:users,id_user',
            'id_prodi' => 'required|exists:prodi,id_prodi',
            'poin_kredit' => 'required|integer|min:0',
            'tahun_angkatan' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
            'beasiswa' => 'required|in:0,1'
        ]);

        // Konversi beasiswa ke boolean untuk database
        $validated['beasiswa'] = (bool) $validated['beasiswa'];

        $mahasiswa->update($validated);

        $role = auth()->user()->role;

        return redirect()->route("$role.mahasiswa.index")
            ->with('success', 'Mahasiswa berhasil diupdate!');
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $nama = $mahasiswa->nama_mhs;
        $mahasiswa->delete();

        $role = auth()->user()->role;

        return redirect()->route("$role.mahasiswa.index")
            ->with('success', "Mahasiswa {$nama} berhasil dihapus!");
    }

    public function exportPdf(Request $request)
    {
        $role = auth()->user()->role;

        $query = Mahasiswa::with(['user', 'prodi.fakultas']);

        // Terapkan filter yang sama seperti index
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_mhs', 'like', "%{$request->search}%")
                    ->orWhere('nim', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('fakultas')) {
            $query->whereHas('prodi', function ($q) use ($request) {
                $q->where('id_fakultas', $request->fakultas);
            });
        }

        if ($request->filled('prodi')) {
            $query->where('id_prodi', $request->prodi);
        }

        if ($request->filled('tahun_angkatan')) {
            $query->where('tahun_angkatan', $request->tahun_angkatan);
        }

        if ($request->filled('beasiswa')) {
            $query->where('beasiswa', $request->beasiswa);
        }

        $mahasiswas = $query->orderBy('nama_mhs')->get();

        // Pakai $role untuk menentukan view
        $pdf = Pdf::loadView("{$role}.mahasiswa.pdf", compact('mahasiswas'));

        return $pdf->download('data-mahasiswa.pdf');
    }
}