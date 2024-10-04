<?php

namespace Database\Seeders;

use App\Models\Aduan;
use App\Models\Terlapor;
use Illuminate\Database\Seeder;

class TerlaporSeeder extends Seeder
{
    public function run()
    {
        // Membuat 10 Terlapor dan setiap Terlapor memiliki 3 Aduan
        Terlapor::factory()
            ->count(10)
            ->withAduans(3)
            ->create();
    }
}
