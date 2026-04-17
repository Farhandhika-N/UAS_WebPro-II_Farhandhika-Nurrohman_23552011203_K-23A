<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $primaryKey = 'id_mahasiswa';
    protected $fillable = ['nim', 'nama', 'id_jurusan'];

    public function jurusan() { return $this->belongsTo(Jurusan::class, 'id_jurusan'); }
}
