<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::create('tagihan', function (Blueprint $table) {
        $table->id();

        // relasi ke pesanan
        $table->unsignedBigInteger('pesanan_id');

        // relasi ke pelanggan
        $table->unsignedBigInteger('pelanggan_id');

        // relasi ke paket
        $table->unsignedBigInteger('paket_id');

        // relasi ke metode pembayaran
        $table->unsignedBigInteger('metode_pembayaran_id')->nullable();

        $table->integer('nominal');

        // nomor tujuan dari metode pembayaran
        $table->string('nomor_pembayaran')->nullable();

        // upload bukti pembayaran
        $table->string('bukti_pembayaran')->nullable();

        $table->enum('status', [
            'menunggu_pembayaran',
            'menunggu_verifikasi',
            'lunas',
            'ditolak'
        ])->default('menunggu_pembayaran');

        $table->text('alasan_penolakan')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan');
    }
};
