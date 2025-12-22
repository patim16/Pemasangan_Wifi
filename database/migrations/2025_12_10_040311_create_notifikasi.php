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
    Schema::create('aktivitas', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // pelanggan yang menerima aktivitas
        $table->string('judul');              // contoh: "Tagihan Bulan Januari"
        $table->text('pesan');                // deskripsi aktivitas
        $table->string('tipe');               // "tagihan", "gangguan", "info"
        $table->timestamp('waktu');           // waktu real saat aktivitas dikirim
        $table->boolean('dibaca')->default(false); // apakah notifikasi sudah dibaca
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
