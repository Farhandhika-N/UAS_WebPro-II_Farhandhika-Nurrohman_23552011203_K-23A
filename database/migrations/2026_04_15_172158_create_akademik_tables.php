<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel Jurusan
        Schema::create('jurusans', function (Blueprint $table) {
            $table->id('id_jurusan');
            $table->string('nama_jurusan');
            $table->char('akreditasi', 1); // A, B, C
            $table->timestamps();
        });

        // Tabel Mahasiswa
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id('id_mahasiswa');
            $table->string('nim')->unique();
            $table->string('nama');
            $table->foreignId('id_jurusan')->constrained('jurusans', 'id_jurusan')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabel Matakuliah
        Schema::create('matakuliahs', function (Blueprint $table) {
            $table->id('id_matakuliah');
            $table->string('nama_matakuliah');
            $table->integer('sks');
            $table->foreignId('id_jurusan')->constrained('jurusans', 'id_jurusan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akademik_tables');
    }
};
