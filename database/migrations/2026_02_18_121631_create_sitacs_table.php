<?php

// File: database/migrations/xxxx_xx_xx_xxxxxx_create_sitacs_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sitacs', function (Blueprint $table) {
            $table->id();
            $table->string('dokumen_file')->nullable(); // Diset nullable dulu untuk jaga-jaga kalau filenya belum diupload saat data dibuat
            $table->date('tgl_masuk');
            $table->date('tgl_terakhir')->nullable();
            $table->date('tgl_deadline');
            $table->enum('status', ['Open', 'Close'])->default('Open');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sitacs');
    }
};