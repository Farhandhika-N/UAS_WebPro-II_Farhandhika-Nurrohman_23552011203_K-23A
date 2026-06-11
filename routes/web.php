<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\MatakuliahController;

Route::redirect('/', '/login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/mahasiswa/export-csv', [MahasiswaController::class, 'exportCsv'])
        ->name('mahasiswa.export-csv');

    Route::get('/mahasiswa/export-excel', [MahasiswaController::class, 'exportExcel'])
        ->name('mahasiswa.export-excel');

    Route::get('/mahasiswa/print', [MahasiswaController::class, 'print'])
        ->name('mahasiswa.print');

    Route::resource('jurusan', JurusanController::class)
        ->except(['show']);

    Route::resource('mahasiswa', MahasiswaController::class)
        ->except(['show']);

    Route::resource('matakuliah', MatakuliahController::class)
        ->except(['show']);

    Route::get('/jurusan/export-excel', [JurusanController::class, 'exportExcel'])
        ->name('jurusan.export-excel');

    Route::get('/jurusan/print', [JurusanController::class, 'print'])
        ->name('jurusan.print');

    Route::get('/matakuliah/export-excel', [MatakuliahController::class, 'exportExcel'])
        ->name('matakuliah.export-excel');

    Route::get('/matakuliah/print', [MatakuliahController::class, 'print'])
        ->name('matakuliah.print');
});

require __DIR__.'/auth.php';