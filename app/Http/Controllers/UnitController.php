<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::all();
        return response()->json(['message' => 'Berhasil mengambil data unit', 'data' => $units]);
    }

    public function store(Request $request)
    {
        $request->validate(['nama_unit' => 'required|string']);
        
        $unit = Unit::create($request->all());
        return response()->json(['message' => 'Data unit berhasil ditambahkan', 'data' => $unit], 201);
    }

    public function show($id)
    {
        $unit = Unit::find($id);
        if (!$unit) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        
        return response()->json(['data' => $unit]);
    }

    public function update(Request $request, $id)
    {
        $unit = Unit::find($id);
        if (!$unit) return response()->json(['message' => 'Data tidak ditemukan'], 404);

        $request->validate(['nama_unit' => 'required|string']);
        $unit->update($request->all());
        
        return response()->json(['message' => 'Data unit berhasil diupdate', 'data' => $unit]);
    }

    public function destroy($id)
    {
        $unit = Unit::find($id);
        if (!$unit) return response()->json(['message' => 'Data tidak ditemukan'], 404);

        $unit->delete();
        return response()->json(['message' => 'Data unit berhasil dihapus']);
    }
}