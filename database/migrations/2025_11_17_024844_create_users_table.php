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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('nama', 100);
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->string('no_hp', 20);

            // kalau tidak pakai nomor KTP, boleh hapus baris ini
            $table->string('ktp', 20)->unique();

            $table->text('alamat');

            // foto KTP
            $table->string('foto_ktp')->nullable();  // <— disini tambahkan

            // role user
            $table->enum('role', ['konsumen', 'teknisi', 'admin', 'super_admin']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
