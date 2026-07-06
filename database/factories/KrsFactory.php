<?php

namespace Database\Factories;

use App\Models\Krs;
use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

class KrsFactory extends Factory
{
    protected $model = Krs::class;

    public function definition(): array
    {
        return [
            'id_mahasiswa' => Mahasiswa::inRandomOrder()->first()->id_mahasiswa,

            'semester' => fake()->numberBetween(1, 8),

            'tahun_ajaran' => fake()->randomElement([
                '2024/2025',
                '2025/2026',
                '2026/2027',
            ]),
        ];
    }
}