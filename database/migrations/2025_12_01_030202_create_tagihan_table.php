<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelanggan_id');
            $table->string('bulan'); // format: 2025-03
            $table->integer('total');
            $table->integer('jatuh_tempo'); // 7 / 17 / 27
            $table->enum('status', ['belum bayar', 'sudah bayar'])->default('belum bayar');
            $table->date('tanggal_bayar')->nullable();
            $table->timestamps();

            $table->foreign('pelanggan_id')->references('id')->on('pelanggan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tagihan');
    }
};
