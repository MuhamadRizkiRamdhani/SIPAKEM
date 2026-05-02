<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fakultas;

class FakultasController extends Controller
{
    public function index()
    {
        $fakultas = Fakultas::with('prodi')->get();

        return view("admin.fakultas.index", compact('fakultas'));
    }

    public function create()
    {
        return view('admin.fakultas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_fakultas' => 'required|string|max:255'
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
            'nama_fakultas' => 'required|string|max:255'
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
