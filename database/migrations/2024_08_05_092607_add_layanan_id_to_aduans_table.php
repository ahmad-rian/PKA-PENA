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
        Schema::table('aduans', function (Blueprint $table) {
            $table->unsignedBigInteger('jenis_layanan_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('aduans', function (Blueprint $table) {
            $table->dropColumn('layanan_id')->change();
        });
    }
};
