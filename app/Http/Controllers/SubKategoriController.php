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
    public function index(Request $request)
    {
        $query = SubKategori::with('kategori');

        // SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_sub_kategori', 'like', "%{$request->search}%")
                    ->orWhere('id_sub_kategori', 'like', "%{$request->search}%");
            });
        }

        // FILTER KATEGORI
        if ($request->kategori) {
            $query->where('id_kategori', $request->kategori);
        }

        // PAGINATION
        $subkategoris = $query->paginate(5)->withQueryString();

        // dropdown
        $kategoris = Kategori::all();

        return view('admin.sub-kategori.index', compact('subkategoris', 'kategoris'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.sub-kategori.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_sub_kategori' => 'required|string|max:255|unique:sub_kategori,nama_sub_kategori',
            'id_kategori' => 'required|exists:kategori,id_kategori'
        ]);

        SubKategori::create($validated);

        return redirect()->route('admin.sub-kategori.index')->with('success', 'Sub Kategori berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id_sub_kategori)
    {
        $subKategori = SubKategori::with('kategori')->findOrFail($id_sub_kategori);
        return view('admin.sub-kategori.show', compact('subKategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_sub_kategori)
    {
        $subKategori = SubKategori::findOrFail($id_sub_kategori);
        $kategoris = Kategori::all();
        return view('admin.sub-kategori.edit', compact('subKategori', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_sub_kategori)
    {
        $validated = $request->validate([
            'nama_sub_kategori' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori'
        ]);

        $subKategori = SubKategori::findOrFail($id_sub_kategori);
        $subKategori->update($validated);

        return redirect()->route('admin.sub-kategori.index')->with('success', 'Sub Kategori berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_sub_kategori)
    {
        $subKategori = SubKategori::findOrFail($id_sub_kategori);
        $subKategori->delete();

        return redirect()->route('admin.sub-kategori.index')->with('success', 'Sub Kategori berhasil dihapus');
    }
}
