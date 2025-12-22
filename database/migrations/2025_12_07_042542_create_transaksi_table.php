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
         Schema::create('transaksi', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('pemesanan_id'); // relasi ke pemesanan
        $table->string('metode')->nullable();       // BCA, DANA, QRIS, COD
        $table->string('status')->default('pending'); // pending / berhasil
        $table->string('bukti')->nullable();        // file upload bukti
        $table->integer('total')->nullable();       // jumlah bayar
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
