<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Psikolog extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_psikolog',
        'no_hp',
        'email',
    ];

    public function aduans()
    {
        return $this->hasMany(Aduan::class, 'psikolog_id');
    }
}
