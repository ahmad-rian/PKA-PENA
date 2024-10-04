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
            $table->unsignedBigInteger('psikolog_id')->nullable()->after('peksos_id');
        });
    }

    public function down()
    {
        Schema::table('aduans', function (Blueprint $table) {
            $table->unsignedBigInteger('psikolog_id')->change();
        });
    }
};
