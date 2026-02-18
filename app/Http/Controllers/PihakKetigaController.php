<?php

namespace App\Http\Controllers;

use App\Models\PihakKetiga;
use Illuminate\Http\Request;

class PihakKetigaController extends Controller
{
    public function index()
    {
        $laporan = PihakKetiga::all();
        return response()->json(['message' => 'Berhasil mengambil data laporan', 'data' => $laporan]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tgl_masuk_laporan' => 'required|date',
            'judul_laporan' => 'required|string',
            'deskripsi' => 'required|string',
            'status' => 'required|in:Open,Close',
            'koordinat' => 'nullable|string',
            'keterangan' => 'nullable|string'
        ]);

        $laporan = PihakKetiga::create($request->all());
        return response()->json(['message' => 'Laporan berhasil ditambahkan', 'data' => $laporan], 201);
    }

    public function show($id)
    {
        $laporan = PihakKetiga::find($id);
        if (!$laporan) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        return response()->json(['data' => $laporan]);
    }

    public function update(Request $request, $id)
    {
        $laporan = PihakKetiga::find($id);
        if (!$laporan) return response()->json(['message' => 'Data tidak ditemukan'], 404);

        $request->validate([
            'tgl_masuk_laporan' => 'sometimes|required|date',
            'judul_laporan' => 'sometimes|required|string',
            'deskripsi' => 'sometimes|required|string',
            'status' => 'sometimes|required|in:Open,Close',
            'koordinat' => 'nullable|string',
            'keterangan' => 'nullable|string'
        ]);

        $laporan->update($request->all());
        return response()->json(['message' => 'Laporan berhasil diupdate', 'data' => $laporan]);
    }

    public function destroy($id)
    {
        $laporan = PihakKetiga::find($id);
        if (!$laporan) return response()->json(['message' => 'Data tidak ditemukan'], 404);

        $laporan->delete();
        return response()->json(['message' => 'Laporan berhasil dihapus']);
    }
}