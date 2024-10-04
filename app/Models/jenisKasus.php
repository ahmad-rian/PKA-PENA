<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jenisKasus extends Model
{
    use HasFactory;
    protected $fillable = [
        'jenis_kasus',
    ];

    public function aduans()
    {
        return $this->belongsToMany(Aduan::class, 'aduan_jenis_kasus', 'aduan_id', 'jenis_kasus_id')->withTimestamps();
    }
}
