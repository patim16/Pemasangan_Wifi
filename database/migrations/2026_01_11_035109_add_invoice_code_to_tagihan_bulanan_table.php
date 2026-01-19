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
    Schema::table('tagihan_bulanan', function (Blueprint $table) {
        $table->string('invoice_code')->nullable()->after('id');
    });
}

public function down()
{
    Schema::table('tagihan_bulanan', function (Blueprint $table) {
        $table->dropColumn('invoice_code');
    });
}
};
