<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;
use App\Models\Sitac;
use App\Models\PihakKetiga;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Menghitung statistik Kegiatan (Open vs Close)
        $kegiatanOpen = Kegiatan::where('status', 'Open')->count();
        $kegiatanClose = Kegiatan::where('status', 'Close')->count();

        // 2. Mengambil 5 kegiatan terbaru beserta nama unitnya
        $kegiatanTerbaru = Kegiatan::with('unit')
                                   ->orderBy('created_at', 'desc')
                                   ->take(5)
                                   ->get();

        // 3. (Bonus) Menghitung tanggungan (Open) di modul lain agar dashboard lebih informatif
        $sitacOpen = Sitac::where('status', 'Open')->count();
        $pihakKetigaOpen = PihakKetiga::where('status', 'Open')->count();

        // Mengembalikan semua data dalam satu respons JSON
        return response()->json([
            'message' => 'Berhasil mengambil data dashboard',
            'data' => [
                'statistik_kegiatan' => [
                    'total_open' => $kegiatanOpen,
                    'total_close' => $kegiatanClose,
                ],
                'kegiatan_terbaru' => $kegiatanTerbaru,
                'tanggungan_lainnya' => [
                    'sitac_open' => $sitacOpen,
                    'pihak_ketiga_open' => $pihakKetigaOpen,
                ]
            ]
        ]);
    }
}