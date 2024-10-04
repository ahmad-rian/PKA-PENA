<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Korban extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_korban',
        'usia_korban',
        'jenis_kelamin_korban',
        'pendidikan_korban',
        'pekerjaan_korban',
        'domisili_korban',
        'kab_kota_korban',
        'provinsi_korban',
        'disabilitas_korban',
    ];


    public function aduans()
    {
        return $this->belongsToMany(Aduan::class, 'aduan_korban', 'korban_id', 'aduan_id')->withTimestamps();
    }
}
