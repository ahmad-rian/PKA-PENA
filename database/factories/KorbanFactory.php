<?php

namespace Database\Factories;

use App\Models\Korban;
use Illuminate\Database\Eloquent\Factories\Factory;

class KorbanFactory extends Factory
{
    protected $model = Korban::class;

    public function definition()
    {
        return [
            'nama_korban' => strtoupper($this->faker->name),
            'usia_korban' => $this->faker->numberBetween(0, 17),
            'jenis_kelamin_korban' => $this->faker->randomElement(['Laki-laki', 'Perempuan', 'Tidak Diketahui']),
            'pendidikan_korban' => $this->faker->randomElement([
                'SD/MI', 'SMP/MTS', 'SMA/MA/SMK', 'D1/D2/D3/D4', 'S1', 'S2', 'S3',
                'Tidak Diketahui', 'Tidak Sekolah', 'PAUD', 'TK', 'Lainnya', 'SLB'
            ]),
            'pekerjaan_korban' => strtoupper($this->faker->jobTitle),
            'domisili_korban' => strtoupper($this->faker->city),
            'kab_kota_korban' => strtoupper($this->faker->city),
            'provinsi_korban' => $this->faker->randomElement([
                'Bali', 'Banten', 'Bengkulu', 'DI Yogyakarta', 'DKI Jakarta', 'Gorontalo',
                'Jambi', 'Jawa Barat', 'Jawa Tengah', 'Jawa Timur', 'Kalimantan Barat',
                'Kalimantan Selatan', 'Kalimantan Tengah', 'Kalimantan Timur', 'Kalimantan Utara',
                'Kepulauan Bangka Belitung', 'Kepulauan Riau', 'Lampung', 'Luar Negeri', 'Maluku',
                'Maluku Utara', 'Nanggroe Aceh Darussalam', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur',
                'Papua', 'Papua Barat', 'Papua Barat Daya', 'Papua Pegunungan', 'Papua Selatan',
                'Riau', 'Sulawesi Barat', 'Sulawesi Selatan', 'Sulawesi Tengah', 'Sulawesi Tenggara',
                'Sulawesi Utara', 'Sumatera Barat', 'Sumatera Selatan', 'Sumatera Utara'
            ]),
            'disabilitas_korban' => $this->faker->randomElement(['Tidak', 'Disabilitas Fisik', 'Disabilitas Intelektual', 'Disabilitas Mental', 'Disabilitas Sensorik', 'Disabilitas Ganda']),
        ];
    }
}
