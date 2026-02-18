<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PihakKetiga extends Model
{
    use HasFactory;

    protected $fillable = [
        'tgl_masuk_laporan', 
        'judul_laporan', 
        'deskripsi', 
        'status', 
        'koordinat', 
        'keterangan'
    ];
}