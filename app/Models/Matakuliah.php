<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    protected $primaryKey = 'id_matakuliah'; 
    protected $fillable = ['nama_matakuliah', 'sks', 'id_jurusan'];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan', 'id_jurusan');
    }
}
