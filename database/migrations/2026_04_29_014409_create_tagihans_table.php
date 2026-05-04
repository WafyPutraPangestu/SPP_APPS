<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id('id_tagihan');
            $table->foreignId('id_siswa')->references('id_siswa')->on('siswas')->onDelete('cascade');
            $table->foreignId('id_kategori')->references('id_kategori')->on('kategori_spps')->onDelete('cascade');
            $table->string('bulan', 20);
            $table->integer('tahun');
            $table->enum('status_tagihan', ['Belum Lunas', 'Lunas'])->default('Belum Lunas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
