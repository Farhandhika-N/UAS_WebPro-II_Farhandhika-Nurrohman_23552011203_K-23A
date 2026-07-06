<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Nilai;
use Illuminate\Database\Eloquent\Factories\Factory;

class NilaiFactory extends Factory
{
    protected $model = Nilai::class;
    
    public function definition(): array
    {
        $angka = fake()->numberBetween(60,100);

        return [

            'id_mahasiswa' => Mahasiswa::query()->inRandomOrder()->value('id_mahasiswa'),

            'id_matakuliah' => Matakuliah::query()->inRandomOrder()->value('id_matakuliah'),

            'nilai_angka' => $angka,

            'nilai_huruf' => match(true){

                $angka >= 85 => 'A',

                $angka >= 75 => 'B',

                $angka >= 65 => 'C',

                default => 'D'
            }

        ];
    }
}