<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelapor;
use App\Models\Aduan;

class PelaporSeeder extends Seeder
{
    public function run()
    {
        // Membuat 50 Pelapor
        Pelapor::factory()
            ->count(50)
            ->create()
            ->each(function ($pelapor) {
                // Menemukan atau membuat beberapa Aduan dan menghubungkannya ke Pelapor ini
                $aduans = Aduan::inRandomOrder()->take(rand(1, 3))->pluck('id');
                $pelapor->aduans()->attach($aduans);
            });
    }
}
