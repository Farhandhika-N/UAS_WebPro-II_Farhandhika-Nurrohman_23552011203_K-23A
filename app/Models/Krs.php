<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    use HasFactory;
    protected $table = 'krs';

    protected $primaryKey = 'id_krs';

    protected $fillable = [
        'id_mahasiswa',
        'semester',
        'tahun_ajaran'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class,'id_mahasiswa');
    }

    public function nilais()
    {
        // Parameter 2: Foreign Key di tabel nilais (id_krs)
        // Parameter 3: Local Key di tabel krs (id_krs)
        return $this->hasMany(Nilai::class, 'id_krs', 'id_krs');
    }
}