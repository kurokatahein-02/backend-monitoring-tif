<?php

// File: database/migrations/xxxx_xx_xx_xxxxxx_create_pihak_ketigas_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pihak_ketigas', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_masuk_laporan');
            $table->string('judul_laporan');
            $table->text('deskripsi');
            $table->enum('status', ['Open', 'Close'])->default('Open');
            $table->string('koordinat')->nullable(); // Diset nullable agar tidak error jika vendor lupa mengisi koordinat
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pihak_ketigas');
    }
};