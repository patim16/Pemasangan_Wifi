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
       Schema::create('pemesanan', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('paket_id');

        $table->string('alamat');
        $table->string('patokan')->nullable();
        $table->text('catatan')->nullable();

        $table->decimal('latitude', 10, 6);
        $table->decimal('longitude', 10, 6);

        $table->string('status')->default('pending'); // pending / approve / instalasi / selesai
        $table->string('invoice_code'); // INV20250101-0001

        $table->timestamps();
    });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
