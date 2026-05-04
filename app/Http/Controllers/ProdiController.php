<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prodi;
use App\Models\Fakultas;

class ProdiController extends Controller
{
    public function index(Request $request)
    {
        $query = Prodi::with('fakultas');

        // SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_prodi', 'like', "%{$request->search}%")
                    ->orWhere('id_prodi', 'like', "%{$request->search}%");
            });
        }

        // FILTER FAKULTAS
        if ($request->fakultas) {
            $query->where('id_fakultas', $request->fakultas);
        }

        // PAGINATION
        $prodis = $query->paginate(5)->withQueryString();

        // buat dropdown filter
        $fakultas = Fakultas::all();

        return view('admin.prodi.index', compact('prodis', 'fakultas'));
    }

    public function create()
    {
        $fakultas = Fakultas::all();
        return view('admin.prodi.create', compact('fakultas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_prodi' => 'required|string|max:255|unique:prodi,nama_prodi',
            'id_fakultas' => 'required|exists:fakultas,id_fakultas'
        ]);

        Prodi::create($validated);
        return redirect()->route('admin.prodi.index')->with('success', 'Prodi berhasil ditambahkan');
    }

    public function show($id)
    {
        return Prodi::findOrFail($id);
    }

    public function edit($id)
    {
        $prodi = Prodi::findOrFail($id);
        $fakultas = Fakultas::all();
        return view('admin.prodi.edit', compact('prodi', 'fakultas'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_prodi' => 'required|string|max:255|unique:prodi,nama_prodi,' . $id . ',id_prodi',
            'id_fakultas' => 'required|exists:fakultas,id_fakultas'
        ]);

        $prodi = Prodi::findOrFail($id);
        $prodi->update($validated);
        return redirect()->route('admin.prodi.index')->with('success', 'Prodi berhasil diupdate');
    }

    public function destroy($id)
    {
        $prodi = Prodi::findOrFail($id);
        $prodi->delete();

        return redirect()->route('admin.prodi.index')
            ->with('success', 'Prodi berhasil dihapus');
    }
}
