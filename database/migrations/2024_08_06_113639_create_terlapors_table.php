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
        Schema::create('terlapors', function (Blueprint $table) {
            $table->id();
            $table->string('nama_terlapor');
            $table->integer('usia_terlapor');
            $table->string('jenis_kelamin_terlapor');
            $table->string('pendidikan_terlapor');
            $table->string('pekerjaan_terlapor');
            $table->string('domisili_terlapor');
            $table->string('kab_kota_terlapor');
            $table->string('provinsi_terlapor');
            $table->string('hubungan_terlapor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terlapors');
    }
};
