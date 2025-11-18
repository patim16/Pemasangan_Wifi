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
    Schema::create('pembayarans', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('transaksi_id');
        $table->string('bukti_pembayaran')->nullable();
        $table->string('metode');
        $table->string('status_pembayaran')->default('pending');
        $table->timestamp('tanggal_upload')->nullable();

        $table->foreign('transaksi_id')->references('id')->on('transaksis');
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
