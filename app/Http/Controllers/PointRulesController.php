<?php

namespace App\Http\Controllers;

use App\Models\PointRules;
use App\Models\Kategori;
use App\Models\SubKategori;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PointRulesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PointRules::with(['kategori', 'subKategori', 'level']);

        // SEARCH
        if ($request->search) {
            $query->where('poin_akhir', 'like', "%{$request->search}%");
        }

        // FILTER KATEGORI
        if ($request->kategori) {
            $query->where('id_kategori', $request->kategori);
        }

        // FILTER LEVEL
        if ($request->level) {
            $query->where('id_level', $request->level);
        }

        $pointRules = $query->paginate(5)->withQueryString();

        $kategoris = Kategori::all();
        $levels = Level::all();

        return view("admin.poin.index", compact('pointRules', 'kategoris', 'levels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        $subKategoris = SubKategori::all();
        $levels = Level::all();
        return view('admin.poin.create', compact('kategoris', 'subKategoris', 'levels'));
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
            'poin_akhir' => 'required|integer|min:0|regex:/^[a-zA-Z0-9\s.,!?-]*$/'
        ]);

        // ✅ VALIDASI RELASI
        if ($request->id_sub_kategori) {
            $sub = SubKategori::find($request->id_sub_kategori);

            if ($sub->id_kategori != $request->id_kategori) {
                return back()
                    ->withErrors(['id_sub_kategori' => 'Sub kategori tidak sesuai dengan kategori'])
                    ->withInput();
            }
        }

        // ✅ VALIDASI DUPLIKAT KOMBINASI
        $exists = PointRules::where('id_kategori', $request->id_kategori)
            ->where('id_sub_kategori', $request->id_sub_kategori)
            ->where('id_level', $request->id_level)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors(['duplicate' => 'Kombinasi kategori, sub kategori, dan level sudah ada'])
                ->withInput();
        }

        PointRules::create($validated);

        return redirect()->route('admin.poin.index')
            ->with('success', 'Point Rules berhasil ditambahkan');
    }
    /**
     * Display the specified resource.
     */
    public function show(PointRules $pointRules)
    {
        return view('admin.poin.show', compact('pointRules'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PointRules $pointRules)
    {
        $kategoris = Kategori::all();
        $subKategoris = SubKategori::all();
        $levels = Level::all();

        return view('admin.poin.edit', compact('pointRules', 'kategoris', 'subKategoris', 'levels'));
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
            'poin_akhir' => 'required|integer|min:0|regex:/^[a-zA-Z0-9\s.,!?-]*$/'
        ]);

        // ✅ VALIDASI RELASI
        if ($request->id_sub_kategori) {
            $sub = SubKategori::find($request->id_sub_kategori);

            if ($sub->id_kategori != $request->id_kategori) {
                return back()
                    ->withErrors(['id_sub_kategori' => 'Sub kategori tidak sesuai dengan kategori'])
                    ->withInput();
            }
        }

        // ✅ VALIDASI DUPLIKAT (kecuali data sendiri)
        $exists = PointRules::where('id_kategori', $request->id_kategori)
            ->where('id_sub_kategori', $request->id_sub_kategori)
            ->where('id_level', $request->id_level)
            ->where('id_rules', '!=', $pointRules->id_rules)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors(['duplicate' => 'Kombinasi kategori, sub kategori, dan level sudah ada'])
                ->withInput();
        }

        $pointRules->update($validated);

        return redirect()->route('admin.poin.index')
            ->with('success', 'Point Rules berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PointRules $pointRules)
    {
        $pointRules->delete();

        return redirect()->route('admin.poin.index')->with('success', 'Point Rules berhasil dihapus');
    }
}
