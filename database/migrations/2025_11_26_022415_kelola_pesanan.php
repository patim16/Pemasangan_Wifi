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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();

            // foreign key ke users
            $table->foreignId('pelanggan_id')
                ->constrained('users')
                ->onDelete('cascade');

            // foreign key ke paket_layanan
            $table->foreignId('paket_id')
                ->constrained('paket_layanan')
                ->onDelete('cascade');

            $table->enum('status', ['pending','diterima','ditolak','jadwal_instalasi','selesai'])
                ->default('pending');

            $table->text('alasan_penolakan')->nullable();
            $table->datetime('jadwal_instalasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan'); // jangan kosong, harus drop table
    }
};
