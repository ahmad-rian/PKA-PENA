<?php

use App\Models\Aduan;
use App\Models\Pelapor;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('aduan_pelapor', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Aduan::class);
            $table->foreignIdFor(Pelapor::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aduan_pelapor');
    }
};
