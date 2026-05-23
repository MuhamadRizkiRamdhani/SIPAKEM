<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fakultas;

class FakultasController extends Controller
{
    public function index(Request $request)
    {
        $query = Fakultas::with('prodi');

        // SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_fakultas', 'like', "%{$request->search}%")
                    ->orWhere('id_fakultas', 'like', "%{$request->search}%");
            });
        }

        // PAGINATION
        $fakultas = $query->paginate(5)->withQueryString();

        return view("admin.fakultas.index", compact('fakultas'));
    }

    public function create()
    {
        return view('admin.fakultas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_fakultas' => 'required|string|max:50|min:5|regex:/^[a-zA-Z\s]+$/|unique:fakultas,nama_fakultas'
        ]);

        Fakultas::create($validated);
        return redirect()->route('admin.fakultas.index')->with('success', 'Fakultas berhasil ditambahkan');
    }

    public function show($id)
    {
        return Fakultas::findOrFail($id);
    }

    public function edit($id)
    {
        $fakultas = Fakultas::findOrFail($id);
        return view('admin.fakultas.edit', compact('fakultas'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_fakultas' => 'required|string|max:50|min:5|regex:/^[a-zA-Z\s]+$/|unique:fakultas,nama_fakultas,' . $id . ',id_fakultas'
        ]);

        $fakultas = Fakultas::findOrFail($id);
        $fakultas->update($validated);
        return redirect()->route('admin.fakultas.index')->with('success', 'Fakultas berhasil diupdate');
    }

    public function destroy($id)
    {
        Fakultas::destroy($id);
        return redirect()->route('admin.fakultas.index')->with('success', 'Fakultas berhasil dihapus');
    }
}
