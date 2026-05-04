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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->string('order_id', 50)->unique();
            $table->foreignId('id_tagihan')->constrained('tagihans', 'id_tagihan')->onDelete('cascade');
            $table->integer('jumlah_bayar');
            $table->string('snap_token', 255)->nullable();
            $table->string('midtrans_transaction_id', 100)->nullable();
            $table->string('metode_bayar', 50)->nullable();
            $table->string('status_pembayaran', 20)->default('pending');
            $table->dateTime('waktu_pembayaran')->nullable();
            $table->json('callback_payload')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
