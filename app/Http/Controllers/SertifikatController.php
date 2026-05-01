<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use App\Models\Kategori;
use App\Models\SubKategori;
use App\Models\Level;
use Illuminate\Http\Request;

class SertifikatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sertifikats = Sertifikat::with(['kategori', 'subKategori', 'level'])->get();
        return view('sertifikat.index', compact('sertifikats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        $subKategoris = SubKategori::all();
        $levels = Level::all();
        return view('sertifikat.create', compact('kategoris', 'subKategoris', 'levels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_sertifikat' => 'required|string|max:255|unique:sertifikat,nama_sertifikat',
            'file_sertifikat' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'id_sub_kategori' => 'nullable|exists:sub_kategori,id_sub_kategori',
            'id_level' => 'nullable|exists:level,id_level'
        ]);

        Sertifikat::create($validated);

        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sertifikat $sertifikat)
    {
        return view('sertifikat.show', compact('sertifikat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sertifikat $sertifikat)
    {
        $kategoris = Kategori::all();
        $subKategoris = SubKategori::all();
        $levels = Level::all();
        return view('sertifikat.edit', compact('sertifikat', 'kategoris', 'subKategoris', 'levels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sertifikat $sertifikat)
    {
        $validated = $request->validate([
            'nama_sertifikat' => 'required|string|max:255|unique:sertifikat,nama_sertifikat,' . $sertifikat->id_sertifikat . ',id_sertifikat',
            'file_sertifikat' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'id_sub_kategori' => 'nullable|exists:sub_kategori,id_sub_kategori',
            'id_level' => 'nullable|exists:level,id_level'
        ]);

        $sertifikat->update($validated);

        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sertifikat $sertifikat)
    {
        $sertifikat->delete();

        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil dihapus');
    }
}
