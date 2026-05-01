<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::with('user')->get();
        return view('admin.data-admin', compact('admins'));
    }

    public function store(Request $request)
    {
        return Admin::create($request->all());
    }

    public function show($id)
    {
        return Admin::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $data = Admin::findOrFail($id);
        $data->update($request->all());
        return $data;
    }

    public function destroy($id)
    {
        Admin::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
