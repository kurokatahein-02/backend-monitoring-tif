<?php

namespace App\Http\Controllers;

use App\Models\Sitac;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SitacController extends Controller
{
    public function index()
    {
        $sitac = Sitac::all();
        // Berkat Accessor di Model tadi, 'status_warna' akan otomatis muncul di JSON!
        return response()->json(['message' => 'Berhasil mengambil data SITAC', 'data' => $sitac]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'dokumen_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048', // Validasi file max 2MB
            'tgl_masuk' => 'required|date',
            'tgl_terakhir' => 'nullable|date',
            'tgl_deadline' => 'required|date',
            'status' => 'required|in:Open,Close'
        ]);

        $data = $request->all();

        // Logika Upload File
        if ($request->hasFile('dokumen_file')) {
            // Simpan file ke folder storage/app/public/sitac_dokumen
            $path = $request->file('dokumen_file')->store('sitac_dokumen', 'public');
            $data['dokumen_file'] = $path;
        }

        $sitac = Sitac::create($data);
        return response()->json(['message' => 'Data SITAC berhasil ditambahkan', 'data' => $sitac], 201);
    }

    public function show($id)
    {
        $sitac = Sitac::find($id);
        if (!$sitac) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        return response()->json(['data' => $sitac]);
    }

    public function update(Request $request, $id)
    {
        $sitac = Sitac::find($id);
        if (!$sitac) return response()->json(['message' => 'Data tidak ditemukan'], 404);

        $request->validate([
            'dokumen_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'tgl_masuk' => 'sometimes|required|date',
            'tgl_terakhir' => 'nullable|date',
            'tgl_deadline' => 'sometimes|required|date',
            'status' => 'sometimes|required|in:Open,Close'
        ]);

        $data = $request->all();

        // Jika user mengupload file baru saat update
        if ($request->hasFile('dokumen_file')) {
            // Hapus file lama jika ada
            if ($sitac->dokumen_file) {
                Storage::disk('public')->delete($sitac->dokumen_file);
            }
            // Simpan file baru
            $path = $request->file('dokumen_file')->store('sitac_dokumen', 'public');
            $data['dokumen_file'] = $path;
        }

        $sitac->update($data);
        return response()->json(['message' => 'Data SITAC berhasil diupdate', 'data' => $sitac]);
    }

    public function destroy($id)
    {
        $sitac = Sitac::find($id);
        if (!$sitac) return response()->json(['message' => 'Data tidak ditemukan'], 404);

        // Hapus file fisik dari server sebelum menghapus data di database
        if ($sitac->dokumen_file) {
            Storage::disk('public')->delete($sitac->dokumen_file);
        }

        $sitac->delete();
        return response()->json(['message' => 'Data SITAC dan file berhasil dihapus']);
    }
}