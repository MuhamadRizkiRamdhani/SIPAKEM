<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengelola;

class PengelolaController extends Controller
{
    public function index()
    {
        return Pengelola::with('user')->get();
    }

    public function store(Request $request)
    {
        return Pengelola::create($request->all());
    }

    public function show($id)
    {
        return Pengelola::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $data = Pengelola::findOrFail($id);
        $data->update($request->all());
        return $data;
    }

    public function destroy($id)
    {
        Pengelola::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
