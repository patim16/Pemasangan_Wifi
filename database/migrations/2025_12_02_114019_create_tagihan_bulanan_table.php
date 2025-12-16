<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tagihan_bulanan', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('pelanggan_id');
            $table->unsignedBigInteger('paket_id');

            $table->string('bulan'); // format 2025-03
            $table->integer('nominal');
            $table->integer('jatuh_tempo'); // 7 / 17 / 27

            $table->date('tanggal_bayar')->nullable();

            $table->enum('status', [
                'belum bayar',         // default
                'dikirim',             // dikirim oleh payment
                'menunggu_verifikasi', // setelah pelanggan upload bukti
                'lunas',               // diverifikasi payment
                'ditolak'              // ditolak payment
            ])->default('belum bayar');

            $table->string('bukti_pembayaran')->nullable();
            $table->text('alasan_penolakan')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tagihan_bulanan');
    }
};
