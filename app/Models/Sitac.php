<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // Pastikan ini ditambahkan untuk memanipulasi tanggal

class Sitac extends Model
{
    use HasFactory;

    protected $fillable = [
        'dokumen_file', 
        'tgl_masuk', 
        'tgl_terakhir', 
        'tgl_deadline', 
        'status'
    ];

    // Memberitahu Laravel untuk selalu menyertakan atribut 'status_warna' saat data dipanggil
    protected $appends = ['status_warna'];

    // Logika perhitungan warna (Merah/Kuning/Hijau)
    public function getStatusWarnaAttribute()
    {
        if ($this->status === 'Close') {
            return 'Biru'; // Opsional: Biru jika sudah selesai/Close
        }

        $sekarang = Carbon::now();
        $deadline = Carbon::parse($this->tgl_deadline);
        $sisaHari = $sekarang->diffInDays($deadline, false); // false agar bisa bernilai minus jika kelewat

        if ($sisaHari <= 7) {
            return 'Merah'; // Kurang dari 7 hari atau sudah lewat deadline
        } elseif ($sisaHari <= 30) {
            return 'Kuning'; // Kurang dari 30 hari
        } else {
            return 'Hijau'; // Masih lama (lebih dari 30 hari)
        }
    }
}