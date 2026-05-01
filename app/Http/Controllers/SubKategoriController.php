<?php

namespace App\Http\Controllers;

use App\Models\SubKategori;
use App\Models\Kategori;
use Illuminate\Http\Request;

class SubKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subKategoris = SubKategori::with('kategori')->get();
        return view('sub-kategori.index', compact('subKategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('sub-kategori.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_sub_kategori' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori'
        ]);

        SubKategori::create($validated);

        return redirect()->route('sub-kategori.index')->with('success', 'Sub Kategori berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubKategori $subKategori)
    {
        return view('sub-kategori.show', compact('subKategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubKategori $subKategori)
    {
        $kategoris = Kategori::all();
        return view('sub-kategori.edit', compact('subKategori', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubKategori $subKategori)
    {
        $validated = $request->validate([
            'nama_sub_kategori' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori'
        ]);

        $subKategori->update($validated);

        return redirect()->route('sub-kategori.index')->with('success', 'Sub Kategori berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubKategori $subKategori)
    {
        $subKategori->delete();

        return redirect()->route('sub-kategori.index')->with('success', 'Sub Kategori berhasil dihapus');
    }
}
