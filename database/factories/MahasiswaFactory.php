<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use App\Models\Jurusan;
use Illuminate\Database\Eloquent\Factories\Factory;

class MahasiswaFactory extends Factory
{

    protected $model = Mahasiswa::class;
    
    public function definition(): array
    {
        return [

            'nim' => fake()->unique()->numerify('23########'),

            'nama' => fake()->name(),

            'jenis_kelamin' => fake()->randomElement(['L','P']),

            'alamat' => fake()->address(),

            'no_hp' => fake()->phoneNumber(),

            'angkatan' => fake()->numberBetween(2022,2025),

            'id_jurusan' => Jurusan::inRandomOrder()->first()->id_jurusan
        ];
    }
}