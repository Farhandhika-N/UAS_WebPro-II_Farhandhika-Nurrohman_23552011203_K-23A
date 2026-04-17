<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $primaryKey = 'id_jurusan';
    protected $fillable = ['nama_jurusan', 'akreditasi'];

    public function mahasiswas() { return $this->hasMany(Mahasiswa::class, 'id_jurusan'); }
    public function matakuliahs() { return $this->hasMany(Matakuliah::class, 'id_jurusan'); }
}
