<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->unsignedBigInteger('teknisi_id')->nullable()->after('paket_id');
        });
    }

    public function down(): void
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->dropColumn('teknisi_id');
        });
    }
};
