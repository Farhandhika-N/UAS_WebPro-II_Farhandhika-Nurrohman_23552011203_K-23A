<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Krs;
use App\Models\Nilai;

class NilaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Nilai::truncate();

        $dataKrs = Krs::with('matakuliahs')->get();

        foreach ($dataKrs as $krs) {

            foreach ($krs->matakuliahs as $matakuliah) {

                $nilaiAngka = rand(60, 100);

                if ($nilaiAngka >= 85) {
                    $nilaiHuruf = 'A';
                } elseif ($nilaiAngka >= 75) {
                    $nilaiHuruf = 'B';
                } elseif ($nilaiAngka >= 65) {
                    $nilaiHuruf = 'C';
                } else {
                    $nilaiHuruf = 'D';
                }

                Nilai::create([
                    'id_krs'  => $krs->id_krs,
                    'id_matakuliah' => $matakuliah->id_matakuliah,
                    'nilai_angka'   => $nilaiAngka,
                    'nilai_huruf'   => $nilaiHuruf,
                ]);
            }
        }
    }
}