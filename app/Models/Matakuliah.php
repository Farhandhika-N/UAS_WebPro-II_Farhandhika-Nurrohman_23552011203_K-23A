<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_matakuliah';

    protected $fillable = [
        'kode_matakuliah',
        'nama_matakuliah',
        'semester',
        'sks',
        'id_jurusan',
        'id_dosen'
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class,'id_jurusan');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class,'id_dosen');
    }

    public function krs()
    {
        return $this->belongsToMany(
            Krs::class,
            'detail_krs',
            'id_matakuliah',
            'id_krs'
        );
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class,'id_matakuliah');
    }
}
