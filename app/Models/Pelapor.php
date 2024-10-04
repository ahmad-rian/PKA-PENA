<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelapor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pelapor',
        'no_hp_pelapor',
        'nik_pelapor',

    ];



    public function aduans()
    {
        return $this->belongsToMany(Aduan::class, 'aduan_pelapor', 'pelapor_id', 'aduan_id')->withTimestamps();
    }
}
