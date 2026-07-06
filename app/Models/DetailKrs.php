<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailKrs extends Model
{
    protected $table = 'detail_krs';

    protected $primaryKey = 'id_detail';

    protected $fillable = [
        'id_krs',
        'id_matakuliah'
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