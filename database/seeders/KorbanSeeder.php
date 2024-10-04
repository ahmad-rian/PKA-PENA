<?php

namespace Database\Seeders;

use App\Models\Korban;
use App\Models\Aduan;
use Illuminate\Database\Seeder;

class KorbanSeeder extends Seeder
{
    public function run()
    {
        // Membuat 50 Korban
        Korban::factory()
            ->count(50)
            ->create()
            ->each(function ($korban) {
                // Menemukan atau membuat beberapa Aduan dan menghubungkannya ke Korban ini
                $aduans = Aduan::inRandomOrder()->take(rand(1, 3))->pluck('id');
                $korban->aduans()->attach($aduans);
            });
    }
}
