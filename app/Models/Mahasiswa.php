<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Nilai;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_mahasiswa';

    protected $fillable = [
        'nim',
        'nama',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'angkatan',
        'id_jurusan'
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan');
    }

    public function krs()
    {
        return $this->hasMany(Krs::class, 'id_mahasiswa');
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'id_mahasiswa');
    }
}
