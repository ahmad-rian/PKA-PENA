<?php

namespace Database\Factories;

use App\Models\Terlapor;
use App\Models\Aduan;
use Illuminate\Database\Eloquent\Factories\Factory;

class TerlaporFactory extends Factory
{
    protected $model = Terlapor::class;

    public function definition()
    {
        return [
            'nama_terlapor' => $this->faker->name,
            'usia_terlapor' => $this->faker->numberBetween(18, 99),
            'jenis_kelamin_terlapor' => $this->faker->randomElement(['Laki-laki', 'Perempuan', 'Tidak Diketahui']),
            'pendidikan_terlapor' => $this->faker->randomElement([
                'SD/MI', 'SMP/MTS', 'SMA/MA/SMK', 'D1/D2/D3/D4', 'S1', 'S2', 'S3', 'Tidak Diketahui', 'Tidak Sekolah', 'PAUD', 'TK', 'Lainnya', 'SLB'
            ]),
            'pekerjaan_terlapor' => $this->faker->jobTitle,
            'domisili_terlapor' => strtoupper($this->faker->city),
            'kab_kota_terlapor' => strtoupper($this->faker->city),
            'provinsi_terlapor' => $this->faker->randomElement([
                'Bali', 'Banten', 'Bengkulu', 'DI Yogyakarta', 'DKI Jakarta', 'Gorontalo', 'Jambi', 'Jawa Barat',
                'Jawa Tengah', 'Jawa Timur', 'Kalimantan Barat', 'Kalimantan Selatan', 'Kalimantan Tengah',
                'Kalimantan Timur', 'Kalimantan Utara', 'Kepulauan Bangka Belitung', 'Kepulauan Riau',
                'Lampung', 'Luar Negeri', 'Maluku', 'Maluku Utara', 'Nanggroe Aceh Darussalam',
                'Nusa Tenggara Barat', 'Nusa Tenggara Timur', 'Papua', 'Papua Barat', 'Papua Barat Daya',
                'Papua Pegunungan', 'Papua Selatan', 'Riau', 'Sulawesi Barat', 'Sulawesi Selatan',
                'Sulawesi Tengah', 'Sulawesi Tenggara', 'Sulawesi Utara', 'Sumatera Barat',
                'Sumatera Selatan', 'Sumatera Utara'
            ]),
            'hubungan_terlapor' => $this->faker->randomElement([
                'Orang Tua', 'Ayah Kandung', 'Ayah Tiri', 'Ibu Kandung', 'Ibu Tiri', 'Keluarga/Saudara',
                'Tetangga', 'Kakek/Nenek', 'Teman Sebaya', 'Berkenalan Online', 'Orang tidak dikenal',
                'Aparat Penegak Hukum', 'Tenaga Pendidik', 'Tokoh Masyarakat', 'Tokoh Agama',
                'Majikan/Atasan', 'Pacar/Mantan Pacar', 'Lainnya'
            ]),
        ];
    }

    public function withAduans(int $count = 3)
    {
        return $this->afterCreating(function (Terlapor $terlapor) use ($count) {
            $aduans = Aduan::inRandomOrder()->take($count)->pluck('id');
            $terlapor->aduans()->attach($aduans);
        });
    }
}
