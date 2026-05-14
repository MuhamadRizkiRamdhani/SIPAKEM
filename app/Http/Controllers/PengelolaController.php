<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengelola;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class PengelolaController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengelola::with('user');

        // SEARCH
        if ($request->search) {
            $query->where('nama_pengelola', 'like', "%{$request->search}%");
        }

        // SORT
        if ($request->sort == 'latest') {
            $query->latest();
        }

        // PAGINATION
        $pengelolas = $query->paginate(6)->withQueryString();

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
        $pengelola = Pengelola::findOrFail($id);
        $pengelola->delete();

        return redirect()->route('admin.pengelola.index')
            ->with('success', 'Pengelola berhasil dihapus');
    }

    public function exportPdf(Request $request)
    {
        $role = auth()->user()->role;

        $query = Pengelola::with('user');

        // SEARCH
        if ($request->filled('search')) {
            $query->where('nama_pengelola', 'like', "%{$request->search}%");
        }

        // SORT
        if ($request->sort == 'latest') {
            $query->latest();
        }

        $pengelolas = $query->orderBy('nama_pengelola')->get();

        $pdf = Pdf::loadView("{$role}.pengelola.pdf", compact('pengelolas'));

        return $pdf->download('data-pengelola.pdf');
    }
}
