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
        Schema::create('matakuliahs', function (Blueprint $table) {

            $table->id('id_matakuliah');

            $table->string('kode_matakuliah')->unique();

            $table->string('nama_matakuliah');

            $table->integer('semester');

            $table->integer('sks');

            $table->foreignId('id_jurusan')
                ->constrained('jurusans', 'id_jurusan')
                ->cascadeOnDelete();

            $table->foreignId('id_dosen')
                ->nullable()
                ->constrained('dosens', 'id_dosen')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matakuliahs');
    }
};