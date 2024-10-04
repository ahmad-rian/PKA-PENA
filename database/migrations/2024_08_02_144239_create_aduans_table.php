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
        Schema::create('aduans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kasus');
            $table->date('tanggal_masuk');
            $table->string('kanal_pengaduan');
            $table->string('kewenangan');
            $table->date('tanggal_kejadian');
            $table->string('provinsi_kejadian');
            $table->string('sumber_tambahan')->nullable();
            $table->text('kronologi_singkat')->nullable();
            $table->foreignId('manajer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('advokat_id')->constrained()->cascadeOnDelete();
            $table->foreignId('peksos_id')->constrained()->cascadeOnDelete();
            $table->foreignId('psikolog_id')->constrained()->cascadeOnDelete();
            $table->foreignId('konselor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('paralegal_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aduans');
    }
};
