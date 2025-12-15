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
        Schema::table('pemesanan', function (Blueprint $table) {

            $table->dateTime('jadwal_survei')->nullable()->after('invoice_code');
            $table->dateTime('jadwal_instalasi')->nullable()->after('jadwal_survei');

            $table->text('laporan_teknisi')->nullable()->after('jadwal_instalasi');
            $table->text('alasan_penolakan')->nullable()->after('laporan_teknisi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->dropColumn([
                'jadwal_survei',
                'jadwal_instalasi',
                'laporan_teknisi',
                'alasan_penolakan'
            ]);
        });
    }
};
