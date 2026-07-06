<?php

namespace Database\Factories;

use App\Models\Matakuliah;
use App\Models\Dosen;
use App\Models\Jurusan;
use Illuminate\Database\Eloquent\Factories\Factory;

class MatakuliahFactory extends Factory
{
    protected $model = Matakuliah::class;

    public function definition(): array
    {
        return [

            'kode_matakuliah' => fake()->unique()->bothify('MK###'),

            'nama_matakuliah' => fake()->randomElement([
                'Basis Data',
                'Pemrograman Web',
                'Algoritma',
                'Jaringan Komputer',
                'Pemrograman Mobile',
                'Artificial Intelligence',
                'Sistem Operasi',
            ]),

            'semester' => fake()->numberBetween(1,8),

            'sks' => fake()->randomElement([2,3,4]),

            'id_dosen' => Dosen::query()->inRandomOrder()->value('id_dosen'),

            'id_jurusan' => Jurusan::query()->inRandomOrder()->value('id_jurusan'),
        ];
    }
}