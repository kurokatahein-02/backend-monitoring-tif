<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kegiatan', 
        'unit_id', 
        'start_date', 
        'end_date', 
        'status'
    ];

    // Relasi: Kegiatan ini milik siapa (Unit mana)
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}