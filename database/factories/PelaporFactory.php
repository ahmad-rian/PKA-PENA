<?php

namespace Database\Factories;

use App\Models\Pelapor;
use Illuminate\Database\Eloquent\Factories\Factory;

class PelaporFactory extends Factory
{
    protected $model = Pelapor::class;

    public function definition()
    {
        return [
            'nik_pelapor' => $this->faker->unique()->numerify('##########'), // Pastikan 16 digit
            'nama_pelapor' => $this->faker->name(),
            'no_hp_pelapor' => $this->faker->phoneNumber(),
        ];
    }
}
