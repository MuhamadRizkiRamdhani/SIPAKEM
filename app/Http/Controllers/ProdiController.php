<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prodi;

class ProdiController extends Controller
{
    public function index()
    {
        $prodis = Prodi::with('fakultas')->get();
        return view('admin.data-prodi', compact('prodis'));
    }

    public function store(Request $request)
    {
        return Prodi::create($request->all());
    }

    public function show($id)
    {
        return Prodi::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $data = Prodi::findOrFail($id);
        $data->update($request->all());
        return $data;
    }

    public function destroy($id)
    {
        Prodi::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
