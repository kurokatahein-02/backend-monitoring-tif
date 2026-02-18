<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi
    protected $fillable = ['nama_unit'];

    // Relasi: 1 Unit punya banyak Kegiatan
    public function kegiatans()
    {
        return $this->hasMany(Kegiatan::class);
    }
}
