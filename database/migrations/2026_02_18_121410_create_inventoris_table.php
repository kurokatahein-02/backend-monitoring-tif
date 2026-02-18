<?php

// File: database/migrations/xxxx_xx_xx_xxxxxx_create_inventoris_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventoris', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->integer('jumlah');
            $table->string('lokasi_penyimpanan');
            // Kategori dibatasi pada OSP, ISP, HIGH, dan ASO
            $table->enum('kategori', ['OSP', 'ISP', 'HIGH', 'ASO']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventoris');
    }
};
