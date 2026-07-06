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
    Schema::create('mahasiswas', function (Blueprint $table) {

        $table->id('id_mahasiswa');

        $table->string('nim')->unique();

        $table->string('nama');

        $table->enum('jenis_kelamin',['L','P']);

        $table->text('alamat')->nullable();

        $table->string('no_hp')->nullable();

        $table->integer('angkatan');

        $table->foreignId('id_jurusan')
            ->constrained('jurusans','id_jurusan')
            ->cascadeOnDelete();

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
