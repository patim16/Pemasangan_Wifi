<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the gimigrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('nama', 100);
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->string('no_hp', 20);
           $table->text('alamat')->nullable();


            // foto KTP
            $table->string('foto_ktp')->nullable();  
            // role user
           $table->enum('role',['superadmin','admin','user','teknisi','payment'])->default('user');


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
