<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paralegal extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_paralegal',
        'no_hp',
        'email',
    ];

    public function aduans()
    {
        return $this->hasMany(Aduan::class, 'paralegal_id');
    }
}
