<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index()
    {
        // Mengambil data kegiatan sekaligus data unitnya (Eager Loading)
        $kegiatan = Kegiatan::with('unit')->get();
        return response()->json(['message' => 'Berhasil mengambil data kegiatan', 'data' => $kegiatan]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string',
            'unit_id' => 'required|exists:units,id', // Memastikan ID unit ada di database
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date', // Validasi tanggal akhir tidak boleh sebelum tanggal mulai
            'status' => 'required|in:Open,Close'
        ]);

        $kegiatan = Kegiatan::create($request->all());
        return response()->json(['message' => 'Data kegiatan berhasil ditambahkan', 'data' => $kegiatan], 201);
    }

    public function show($id)
    {
        $kegiatan = Kegiatan::with('unit')->find($id);
        if (!$kegiatan) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        
        return response()->json(['data' => $kegiatan]);
    }

    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::find($id);
        if (!$kegiatan) return response()->json(['message' => 'Data tidak ditemukan'], 404);

        $request->validate([
            'nama_kegiatan' => 'sometimes|required|string',
            'unit_id' => 'sometimes|required|exists:units,id',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
            'status' => 'sometimes|required|in:Open,Close'
        ]);

        $kegiatan->update($request->all());
        return response()->json(['message' => 'Data kegiatan berhasil diupdate', 'data' => $kegiatan]);
    }

    public function destroy($id)
    {
        $kegiatan = Kegiatan::find($id);
        if (!$kegiatan) return response()->json(['message' => 'Data tidak ditemukan'], 404);

        $kegiatan->delete();
        return response()->json(['message' => 'Data kegiatan berhasil dihapus']);
    }
}