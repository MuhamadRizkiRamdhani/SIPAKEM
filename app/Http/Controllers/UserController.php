<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        return User::create($request->all());
    }

    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $data = User::findOrFail($id);
        $data->update($request->all());
        return $data;
    }

    public function destroy($id)
    {
        User::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
