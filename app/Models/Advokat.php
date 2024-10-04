<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advokat extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_advokat',
        'no_hp',
        'email',
    ];

    public function aduans()
    {
        return $this->hasMany(Aduan::class, 'advokat_id');
    }
}
