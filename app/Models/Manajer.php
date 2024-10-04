<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manajer extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_mk',
        'no_hp',
        'email',
    ];

    public function aduans()
    {
        return $this->hasMany(Aduan::class, 'manajer_id');
    }
}
