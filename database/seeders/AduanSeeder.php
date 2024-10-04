<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aduan;

class AduanSeeder extends Seeder
{
    public function run(): void
    {
        Aduan::factory()->count(100)->create();
    }
}
