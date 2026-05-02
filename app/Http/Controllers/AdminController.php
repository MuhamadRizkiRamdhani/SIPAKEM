<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::with('user')->get();
        return view('admin.admin.index', compact('admins'));
    }

    public function create()
    {
        $users = User::where('role', 'admin')->doesntHave('admin')->get();
        return view('admin.admin.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_admin' => 'required|string|max:255',
            'id_user' => 'required|exists:users,id_user'
        ]);

        Admin::create($validated);
        return redirect()->route('admin.admin.index')->with('success', 'Admin berhasil ditambahkan');
    }

    public function show($id)
    {
        return Admin::findOrFail($id);
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        $users = User::where('role', 'admin')->get();
        return view('admin.admin.edit', compact('admin', 'users'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_admin' => 'required|string|max:255',
            'id_user' => 'required|exists:users,id_user'
        ]);

        $admin = Admin::findOrFail($id);
        $admin->update($validated);
        return redirect()->route('admin.admin.index')->with('success', 'Admin berhasil diupdate');
    }

    public function destroy($id)
    {
        Admin::destroy($id);
        return redirect()->route('admin.admin.index')->with('success', 'Admin berhasil dihapus');
    }
}
