<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;

class AkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat Data Jurusan
        $ti = Jurusan::create(['nama_jurusan' => 'Teknik Informatika', 'akreditasi' => 'A']);
        $si = Jurusan::create(['nama_jurusan' => 'Sistem Informasi', 'akreditasi' => 'B']);

        // Buat Data Mahasiswa
        Mahasiswa::create(['nim' => '211001', 'nama' => 'Rizky Pratama', 'id_jurusan' => $ti->id_jurusan]);
        Mahasiswa::create(['nim' => '211002', 'nama' => 'Nisa Salsabila', 'id_jurusan' => $si->id_jurusan]);

        // Buat Data Matakuliah
        Matakuliah::create(['nama_matakuliah' => 'Pemrograman Web Berbasis Framework', 'sks' => 3, 'id_jurusan' => $ti->id_jurusan]);
        Matakuliah::create(['nama_matakuliah' => 'Keamanan Jaringan & Kriptografi', 'sks' => 3, 'id_jurusan' => $ti->id_jurusan]);
        Matakuliah::create(['nama_matakuliah' => 'Analisis Proses Bisnis', 'sks' => 2, 'id_jurusan' => $si->id_jurusan]);
    }
}
