<?php

namespace Database\Factories;

use App\Models\Aduan;
use App\Models\JenisKasus;
use App\Models\Layanan;
use App\Models\Manajer;
use App\Models\Advokat;
use App\Models\Peksos;
use App\Models\Psikolog;
use App\Models\Konselor;
use App\Models\Paralegal;
use Illuminate\Database\Eloquent\Factories\Factory;

class AduanFactory extends Factory
{
    protected $model = Aduan::class;

    public function definition(): array
    {
        // Menghasilkan data untuk tabel aduan tanpa relasi
        return [
            'kode_kasus' => $this->faker->unique()->bothify('KASUS-####'),
            'tanggal_masuk' => $this->faker->dateTimeBetween('2024-08-01', '2025-01-31')->format('Y-m-d'),
            'kanal_pengaduan' => $this->faker->randomElement([
                'NON ADUAN - LAPORAN MEDIA',
                'NOTA DINAS',
                'PENGADUAN LANGSUNG',
                'SAPA 129 - GFORM',
                'SAPA 129 - HOTLINE WA',
                'SAPA 129 - TELEPON',
                'SP4N LAPOR',
                'SURAT',
                'Mobile Apps'
            ]),
            'kewenangan' => $this->faker->randomElement(['daerah', 'pusat']),
            'tanggal_kejadian' => $this->faker->dateTimeBetween('2024-08-01', '2025-01-31')->format('Y-m-d'),
            'provinsi_kejadian' => $this->faker->randomElement([
                'Bali', 'Banten', 'Bengkulu', 'DI Yogyakarta', 'DKI Jakarta',
                'Gorontalo', 'Jambi', 'Jawa Barat', 'Jawa Tengah', 'Jawa Timur',
                'Kalimantan Barat', 'Kalimantan Selatan', 'Kalimantan Tengah',
                'Kalimantan Timur', 'Kalimantan Utara', 'Kepulauan Bangka Belitung',
                'Kepulauan Riau', 'Lampung', 'Luar Negeri', 'Maluku', 'Maluku Utara',
                'Nanggroe Aceh Darussalam', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur',
                'Papua', 'Papua Barat', 'Papua Barat Daya', 'Papua Pegunungan',
                'Papua Selatan', 'Riau', 'Sulawesi Barat', 'Sulawesi Selatan',
                'Sulawesi Tengah', 'Sulawesi Tenggara', 'Sulawesi Utara', 'Sumatera Barat',
                'Sumatera Selatan', 'Sumatera Utara'
            ]),
            'tempat_kejadian' => $this->faker->randomElement([
                'Rumah Tangga', 'Tempat Kerja', 'Sekolah', 'Fasilitas Umum',
                'Lembaga Pendidikan', 'Lembaga Pendidikan Kilat', 'Lainnya'
            ]),
            'sumber_tambahan' => $this->faker->word(),
            'kronologi_singkat' => $this->faker->paragraph(),
            'manajer_id' => Manajer::inRandomOrder()->first()->id,
            'advokat_id' => Advokat::inRandomOrder()->first()->id,
            'peksos_id' => Peksos::inRandomOrder()->first()->id,
            'psikolog_id' => Psikolog::inRandomOrder()->first()->id,
            'konselor_id' => Konselor::inRandomOrder()->first()->id,
            'paralegal_id' => Paralegal::inRandomOrder()->first()->id,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Aduan $aduan) {
            // Mengambil beberapa jenis kasus secara acak dan melampirkannya ke aduan
            $jenisKasus = JenisKasus::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $aduan->jenisKasus()->attach($jenisKasus);

            // Mengambil beberapa layanan secara acak dan melampirkannya ke aduan
            $layanan = Layanan::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $aduan->jenislayanan()->attach($layanan);
        });
    }
}
