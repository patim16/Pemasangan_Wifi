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
    Schema::create('instalasis', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('transaksi_id');
        $table->unsignedBigInteger('teknisi_id');
        $table->date('tanggal_pemasangan')->nullable();
        $table->string('lokasi_instalasi');
        $table->string('status_instalasi')->default('pending');
        $table->text('catatan_teknisi')->nullable();
        $table->timestamp('tanggal_update')->nullable();
        $table->timestamp('tanggal_daftar')->nullable();

        $table->foreign('transaksi_id')->references('id')->on('transaksis');
        $table->foreign('teknisi_id')->references('id')->on('users');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instalasis');
    }
};
