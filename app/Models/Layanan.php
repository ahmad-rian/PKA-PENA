<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;
    protected $fillable = [
        'jenis_layanan',
    ];

    public function aduans()
    {
        return $this->belongsToMany(Aduan::class, 'aduan_layanan', 'aduan_id', 'jenis_layanan_id')->withTimestamps();
    }
}
