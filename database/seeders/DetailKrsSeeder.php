<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Krs;
use App\Models\Matakuliah;
use App\Models\DetailKrs;

class DetailKrsSeeder extends Seeder
{
    public function run(): void
    {
        $matakuliahs = Matakuliah::pluck('id_matakuliah')->toArray();

        foreach (Krs::all() as $krs) {

            $jumlahMatkul = rand(3, 6);

            $pilihan = collect($matakuliahs)
                ->shuffle()
                ->take($jumlahMatkul);

            foreach ($pilihan as $matkul) {

                DetailKrs::create([
                    'id_krs' => $krs->id_krs,
                    'id_matakuliah' => $matkul,
                ]);

            }
        }
    }
}