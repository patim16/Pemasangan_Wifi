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
    Schema::create('transaksis', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('pelanggan_id');
        $table->unsignedBigInteger('paket_id');
        $table->integer('total');
        $table->string('bukti')->nullable();
        $table->enum('status', ['menunggu', 'terverifikasi', 'ditolak'])->default('menunggu');
        $table->text('alasan_penolakan')->nullable();
        $table->timestamps();

        $table->foreign('pelanggan_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('paket_id')->references('id')->on('paket_layanans')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
