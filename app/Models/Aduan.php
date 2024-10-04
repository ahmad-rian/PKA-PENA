<?php

namespace App\Models;

use App\Models\Pelapor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aduan extends Model
{
    use HasFactory;

    // Definisikan atribut yang dapat diisi secara massal
    protected $fillable = [
        'kode_kasus',
        'tanggal_masuk',
        'kanal_pengaduan',
        'kewenangan',
        'tanggal_kejadian',
        'provinsi_kejadian',
        'sumber_tambahan',
        'kronologi_singkat',
        'manajer_id',
    ];

    // Jika ada relasi dengan model lain, misalnya Manajer

    public function manajer()
    {
        return $this->belongsTo(Manajer::class, 'manajer_id');
    }

    public function advokat()
    {
        return $this->belongsTo(Advokat::class, 'advokat_id');
    }

    public function peksos()
    {
        return $this->belongsTo(Peksos::class, 'peksos_id');
    }

    public function psikolog()
    {
        return $this->belongsTo(Psikolog::class, 'psikolog_id');
    }

    public function konselor()
    {
        return $this->belongsTo(Konselor::class, 'konselor_id');
    }

    public function paralegal()
    {
        return $this->belongsTo(Paralegal::class, 'paralegal_id');
    }

    public function jeniskasus()
    {
        return $this->belongsToMany(jenisKasus::class, 'aduan_jenis_kasus', 'aduan_id', 'jenis_kasus_id')->withTimestamps();
    }

    public function jenislayanan()
    {
        return $this->belongsToMany(Layanan::class, 'aduan_jenis_layanan', 'aduan_id', 'layanan_id')->withTimestamps();
    }

    public function korban()
    {
        return $this->belongsToMany(Korban::class, 'aduan_korban', 'aduan_id', 'korban_id')->withTimestamps();
    }

    public function terlapor()
    {
        return $this->belongsToMany(Terlapor::class, 'aduan_terlapor', 'aduan_id', 'terlapor_id')->withTimestamps();
    }

    public function pelapor()
    {
        return $this->belongsToMany(Pelapor::class, 'aduan_pelapor', 'aduan_id', 'pelapor_id')->withTimestamps();
    }

    public function setKodeKasusAttribute($value)
    {
        $this->attributes['kode_kasus'] = 'aduan-' . $value;
    }
}
