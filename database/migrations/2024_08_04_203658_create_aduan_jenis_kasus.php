<?php

use App\Models\Aduan;
use App\Models\jenisKasus;
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
        Schema::create('aduan_jenis_kasus', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Aduan::class);
            $table->foreignIdFor(jenisKasus::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aduan_jenis_kasus');
    }
};
