<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengelola;
use App\Models\User;

class PengelolaController extends Controller
{
    public function index()
    {
        $pengelolas = Pengelola::with('user')->get();
        return view('admin.pengelola.index', compact('pengelolas'));
    }

    public function create()
    {
        $users = User::where('role', 'pengelola')->doesntHave('pengelola')->get();
        return view('admin.pengelola.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pengelola' => 'required|string|max:255',
            'id_user' => 'required|exists:users,id_user'
        ]);

        Pengelola::create($validated);
        return redirect()->route('admin.pengelola.index')->with('success', 'Pengelola berhasil ditambahkan');
    }

    public function show($id)
    {
        return Pengelola::findOrFail($id);
    }

    public function edit($id)
    {
        $pengelola = Pengelola::findOrFail($id);
        $users = User::where('role', 'pengelola')->get();
        return view('admin.pengelola.edit', compact('pengelola', 'users'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_pengelola' => 'required|string|max:255',
            'id_user' => 'required|exists:users,id_user'
        ]);

        $pengelola = Pengelola::findOrFail($id);
        $pengelola->update($validated);
        return redirect()->route('admin.pengelola.index')->with('success', 'Pengelola berhasil diupdate');
    }

    public function destroy($id)
    {
        Pengelola::destroy($id);
        return redirect()->route('admin.pengelola.index')->with('success', 'Pengelola berhasil dihapus');
    }
}
