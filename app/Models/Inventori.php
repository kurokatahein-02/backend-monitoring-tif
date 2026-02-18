<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventori extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang', 
        'jumlah', 
        'lokasi_penyimpanan', 
        'kategori'
    ];
}