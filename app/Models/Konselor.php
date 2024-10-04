<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konselor extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_konselor',
        'no_hp',
        'email',
    ];

    public function aduans()
    {
        return $this->hasMany(Aduan::class, 'konselor_id');
    }
}
