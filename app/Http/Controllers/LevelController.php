<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $levels = Level::with(['sertifikat', 'pointRules'])->get();
        return view('level.index', compact('levels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('level.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_level' => 'required|string|max:255|unique:level,nama_level'
        ]);

        Level::create($validated);

        return redirect()->route('level.index')->with('success', 'Level berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Level $level)
    {
        return view('level.show', compact('level'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Level $level)
    {
        return view('level.edit', compact('level'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Level $level)
    {
        $validated = $request->validate([
            'nama_level' => 'required|string|max:255|unique:level,nama_level,' . $level->id_level . ',id_level'
        ]);

        $level->update($validated);

        return redirect()->route('level.index')->with('success', 'Level berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Level $level)
    {
        $level->delete();

        return redirect()->route('level.index')->with('success', 'Level berhasil dihapus');
    }
}
