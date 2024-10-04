<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peksos extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_peksos',
        'no_hp',
        'email',
    ];

    public function aduans()
    {
        return $this->hasMany(Aduan::class, 'peksos_id');
    }
}
