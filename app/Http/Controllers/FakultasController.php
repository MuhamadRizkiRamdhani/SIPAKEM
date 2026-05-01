<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fakultas;

class FakultasController extends Controller
{
    public function index()
    {
        $fakultas = Fakultas::with('prodi')->get();

        return view("admin.fakultas.index", compact('fakultas'));
    }

    public function store(Request $request)
    {
        return Fakultas::create($request->all());
    }

    public function show($id)
    {
        return Fakultas::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $data = Fakultas::findOrFail($id);
        $data->update($request->all());
        return $data;
    }

    public function destroy($id)
    {
        Fakultas::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
