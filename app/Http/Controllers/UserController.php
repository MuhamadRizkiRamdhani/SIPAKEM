<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('username', 'like', "%{$request->search}%")
                    ->orWhere('id_user', 'like', "%{$request->search}%");
            });
        }

        // FILTER ROLE
        if ($request->role) {
            $query->where('role', $request->role);
        }

        // PAGINATION
        $users = $query->paginate(6)->withQueryString();

        return view('admin.users.index', compact('users'));

    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|min:5|max:50|unique:users|regex:/^[a-zA-Z0-9_]+$/',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,pengelola,mahasiswa'
        ]);

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('admin.pengguna.index')->with('success', 'User berhasil ditambahkan');
    }

    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'username' => 'required|string|min:5|max:50|regex:/^[a-zA-Z0-9_]+$/|unique:users,username,' . $id . ',id_user',
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:admin,pengelola,mahasiswa'
        ]);

        if ($validated['password']) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        return redirect()->route('admin.pengguna.index')->with('success', 'User berhasil diupdate');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('admin.pengguna.index')->with('success', 'User berhasil dihapus');
    }
}
