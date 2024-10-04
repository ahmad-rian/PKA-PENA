<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aduan;
use App\Models\Korban;
use App\Models\Terlapor;
use App\Models\Pelapor;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Membuat 50 Aduan
        Aduan::factory()
            ->count(50)
            ->create()
            ->each(function ($aduan) {
                // Membuat dan menambahkan 3 Korban secara acak ke setiap Aduan
                $korbans = Korban::factory()->count(3)->create();
                $aduan->korban()->attach($korbans);

                // Membuat dan menambahkan 2 Terlapor secara acak ke setiap Aduan
                $terlapors = Terlapor::factory()->count(2)->create();
                $aduan->terlapor()->attach($terlapors);

                // Membuat dan menambahkan 2 Pelapor secara acak ke setiap Aduan
                $pelapors = Pelapor::factory()->count(2)->create();
                $aduan->pelapor()->attach($pelapors);
            });
    }
}
