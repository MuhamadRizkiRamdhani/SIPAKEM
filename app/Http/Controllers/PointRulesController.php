<?php

namespace App\Http\Controllers;

use App\Models\PointRules;
use App\Models\Kategori;
use App\Models\SubKategori;
use App\Models\Level;
use Illuminate\Http\Request;

class PointRulesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pointRules = PointRules::with(['kategori', 'subKategori', 'level'])->get();

        return view("admin.poin.index", compact('pointRules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        $subKategoris = SubKategori::all();
        $levels = Level::all();
        return view('point-rules.create', compact('kategoris', 'subKategoris', 'levels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'id_sub_kategori' => 'nullable|exists:sub_kategori,id_sub_kategori',
            'id_level' => 'nullable|exists:level,id_level',
            'poin_akhir' => 'required|integer|min:0'
        ]);

        PointRules::create($validated);

        return redirect()->route('point-rules.index')->with('success', 'Point Rules berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(PointRules $pointRules)
    {
        return view('point-rules.show', compact('pointRules'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PointRules $pointRules)
    {
        $kategoris = Kategori::all();
        $subKategoris = SubKategori::all();
        $levels = Level::all();
        return view('point-rules.edit', compact('pointRules', 'kategoris', 'subKategoris', 'levels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PointRules $pointRules)
    {
        $validated = $request->validate([
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'id_sub_kategori' => 'nullable|exists:sub_kategori,id_sub_kategori',
            'id_level' => 'nullable|exists:level,id_level',
            'poin_akhir' => 'required|integer|min:0'
        ]);

        $pointRules->update($validated);

        return redirect()->route('point-rules.index')->with('success', 'Point Rules berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PointRules $pointRules)
    {
        $pointRules->delete();

        return redirect()->route('point-rules.index')->with('success', 'Point Rules berhasil dihapus');
    }
}
