<?php

namespace Database\Factories;

use App\Models\DetailKrs;
use App\Models\Krs;
use App\Models\Matakuliah;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetailKrsFactory extends Factory
{
    protected $model = DetailKrs::class;

    public function definition(): array
    {
        return [
            'id_krs' => Krs::inRandomOrder()->first()->id_krs,

            'id_matakuliah' => Matakuliah::inRandomOrder()->first()->id_matakuliah,
        ];
    }
}