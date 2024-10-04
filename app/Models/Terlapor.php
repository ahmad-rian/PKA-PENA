<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terlapor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_terlapor',
        'usia_terlapor',
        'jenis_kelamin_terlapor',
        'pendidikan_terlapor',
        'pekerjaan_terlapor',
        'domisili_terlapor',
        'kab_kota_terlapor',
        'provinsi_terlapor',
        'hubungan_terlapor',
    ];

    public function aduans()
    {
        return $this->belongsToMany(Aduan::class, 'aduan_terlapor', 'terlapor_id', 'aduan_id')->withTimestamps();
    }
}
