<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Prodi;


class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::with(['user', 'prodi'])->get();
        return view('admin.data-mahasiswa', compact('mahasiswas'));
    }

    public function store(Request $request)
    {
        return Mahasiswa::create($request->all());
    }

    public function show($id)
    {
        return Mahasiswa::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $data = Mahasiswa::findOrFail($id);
        $data->update($request->all());
        return $data;
    }

    public function destroy($id)
    {
        Mahasiswa::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
