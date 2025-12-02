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
    Schema::table('metode_pembayaran', function (Blueprint $table) {
        $table->string('nomor_pembayaran')->nullable()->after('deskripsi');
    });
}

public function down()
{
    Schema::table('metode_pembayaran', function (Blueprint $table) {
        $table->dropColumn('nomor_pembayaran');
    });
}

};
