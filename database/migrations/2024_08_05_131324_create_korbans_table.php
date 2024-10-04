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
        Schema::create('korbans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_korban');
            $table->integer('usia_korban');
            $table->string('jenis_kelamin_korban');
            $table->string('pendidikan_korban');
            $table->string('pekerjaan_korban');
            $table->string('domisili_korban');
            $table->string('kab_kota_korban');
            $table->string('provinsi_korban');
            $table->string('disabilitas_korban'); // Asumsi disabilitas adalah tipe boolean
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('korbans');
    }
};
