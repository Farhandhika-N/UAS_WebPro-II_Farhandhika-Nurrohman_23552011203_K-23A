<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Jurusan;

class JurusanFactory extends Factory
{
    protected $model = Jurusan::class;

    public function definition(): array
    {
        return [
            'nama_jurusan' => fake()->randomElement([
                'Teknik Informatika',
                'Sistem Informasi',
                'Teknik Komputer',
                'Manajemen Informatika',
                'Teknologi Informasi'
            ]),
            'akreditasi' => fake()->randomElement(['A','B','C'])
        ];
    }
}