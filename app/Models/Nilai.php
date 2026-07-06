<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;
    protected $table = 'nilais';

    protected $primaryKey = 'id_nilai';

    protected $fillable = [
        'id_krs',
        'id_matakuliah',
        'nilai_angka',
        'nilai_huruf'
    ];

    public function krs()
    {
        return $this->belongsTo(Krs::class,'id_krs');
    }

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class,'id_matakuliah');
    }
}