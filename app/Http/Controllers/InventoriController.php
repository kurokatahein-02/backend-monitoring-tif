<?php

namespace App\Http\Controllers;

use App\Models\Inventori;
use Illuminate\Http\Request;

class InventoriController extends Controller
{
    // 1. READ (Menampilkan semua data inventori)
    public function index()
    {
        $inventori = Inventori::all();
        return response()->json([
            'message' => 'Berhasil mengambil data inventori',
            'data' => $inventori
        ]);
    }

    // 2. CREATE (Menyimpan data inventori baru)
    public function store(Request $request)
    {
        // Validasi input dari user
        $request->validate([
            'nama_barang' => 'required|string',
            'jumlah' => 'required|integer',
            'lokasi_penyimpanan' => 'required|string',
            'kategori' => 'required|in:OSP,ISP,HIGH,ASO' // Validasi sesuai kategori yang diizinkan
        ]);

        // Simpan ke database
        $inventori = Inventori::create($request->all());

        return response()->json([
            'message' => 'Data inventori berhasil ditambahkan',
            'data' => $inventori
        ], 201); // 201 artinya Created
    }

    // 3. READ DETAIL (Menampilkan satu data spesifik berdasarkan ID)
    public function show($id)
    {
        $inventori = Inventori::find($id);

        if (!$inventori) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json(['data' => $inventori]);
    }

    // 4. UPDATE (Mengubah data inventori)
    public function update(Request $request, $id)
    {
        $inventori = Inventori::find($id);

        if (!$inventori) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $request->validate([
            'nama_barang' => 'sometimes|required|string',
            'jumlah' => 'sometimes|required|integer',
            'lokasi_penyimpanan' => 'sometimes|required|string',
            'kategori' => 'sometimes|required|in:OSP,ISP,HIGH,ASO'
        ]);

        $inventori->update($request->all());

        return response()->json([
            'message' => 'Data inventori berhasil diupdate',
            'data' => $inventori
        ]);
    }

    // 5. DELETE (Menghapus data inventori)
    public function destroy($id)
    {
        $inventori = Inventori::find($id);

        if (!$inventori) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $inventori->delete();

        return response()->json(['message' => 'Data inventori berhasil dihapus']);
    }
}