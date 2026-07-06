<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_dosen';

    protected $fillable = [

        'nidn',
        'nama_dosen',
        'email',
        'no_hp',
        'alamat',

    ];

    public function matakuliahs()
    {
        return $this->hasMany(
            Matakuliah::class,
            'id_dosen',
            'id_dosen'
        );
    }
}