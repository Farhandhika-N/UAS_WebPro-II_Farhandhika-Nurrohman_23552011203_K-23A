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
        Schema::create('nilais', function (Blueprint $table) {
            $table->id('id_nilai');

            $table->foreignId('id_krs')
                ->constrained('krs', 'id_krs')
                ->cascadeOnDelete();

            $table->foreignId('id_matakuliah')
                ->constrained('matakuliahs', 'id_matakuliah')
                ->cascadeOnDelete();

            $table->decimal('nilai_angka', 5, 2);
            $table->char('nilai_huruf', 2);

            $table->unique([
            'id_krs',
            'id_matakuliah'
        ]);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
