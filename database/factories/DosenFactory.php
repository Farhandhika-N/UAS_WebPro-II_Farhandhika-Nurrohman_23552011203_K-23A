<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Dosen;

class DosenFactory extends Factory
{

    protected $model = Dosen::class;

    public function definition(): array
    {
        return [

            'nidn' => fake()->unique()->numerify('##########'),

            'nama_dosen' => fake()->name(),

            'email' => fake()->unique()->safeEmail(),

            'no_hp' => fake()->phoneNumber(),

            'alamat' => fake()->address(),

        ];
    }
}