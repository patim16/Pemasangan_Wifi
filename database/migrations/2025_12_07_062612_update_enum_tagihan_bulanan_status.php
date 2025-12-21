<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        DB::statement("
            ALTER TABLE tagihan_bulanan 
            MODIFY COLUMN status 
            ENUM(
                'belum bayar',
                'dikirim',
                'menunggu_verifikasi',
                'lunas',
                'ditolak'
            ) 
            NOT NULL DEFAULT 'belum bayar'
        ");
    }

    public function down()
    {
        // Mengembalikan ENUM ke kondisi awal (tanpa 'dikirim')
        DB::statement("
            ALTER TABLE tagihan_bulanan 
            MODIFY COLUMN status 
            ENUM(
                'belum bayar',
                'menunggu_verifikasi',
                'lunas',
                'ditolak'
            ) 
            NOT NULL DEFAULT 'belum bayar'
        ");
    }
};
