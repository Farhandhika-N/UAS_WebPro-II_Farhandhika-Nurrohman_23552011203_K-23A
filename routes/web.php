<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\JurusanController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\KrsController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\TranskripController;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\ActivityLogController;

Route::redirect('/', '/login');

Route::middleware(['auth'])->group(function () {

    /* Dashboard */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /* Profile */
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /* ADMIN ONLY */
    Route::middleware('admin')->group(function () {

        Route::get('/jurusan/export-excel', [JurusanController::class, 'exportExcel'])
            ->name('jurusan.export-excel');

        Route::get('/jurusan/print', [JurusanController::class, 'print'])
            ->name('jurusan.print');

        Route::resource('jurusan', JurusanController::class);

        Route::resource('user', UserController::class);

        Route::get('/activity-log', [ActivityLogController::class, 'index'])
        ->name('activity-log.index');

        /* Manajemen User */

        Route::resource('user', UserController::class);

        Route::get('/user/{user}/password', [UserController::class, 'editPassword'])
            ->name('user.password.edit');

        Route::put('/user/{user}/password', [UserController::class, 'updatePassword'])
            ->name('user.password.update');

    });

    /* ADMIN & PETUGAS */
    Route::middleware('petugas')->group(function () {

        /* Mahasiswa */
        Route::get('/mahasiswa/export-csv', [MahasiswaController::class, 'exportCsv'])
            ->name('mahasiswa.export-csv');

        Route::get('/mahasiswa/export-excel', [MahasiswaController::class, 'exportExcel'])
            ->name('mahasiswa.export-excel');

        Route::get('/mahasiswa/print', [MahasiswaController::class, 'print'])
            ->name('mahasiswa.print');

        Route::resource('mahasiswa', MahasiswaController::class);

        /* Dosen */
        Route::get('/dosen/export-excel', [DosenController::class, 'exportExcel'])
            ->name('dosen.export-excel');

        Route::get('/dosen/print', [DosenController::class, 'print'])
            ->name('dosen.print');

        Route::resource('dosen', DosenController::class);

        /* Mata Kuliah */
        Route::get('/matakuliah/export-excel', [MatakuliahController::class, 'exportExcel'])
            ->name('matakuliah.export-excel');

        Route::get('/matakuliah/print', [MatakuliahController::class, 'print'])
            ->name('matakuliah.print');

        Route::resource('matakuliah', MatakuliahController::class);

        /* KRS */
        Route::get('/krs/export-excel', [KrsController::class, 'exportExcel'])
            ->name('krs.export-excel');

        Route::get('/krs/print', [KrsController::class, 'print'])
            ->name('krs.print');

        Route::resource('krs', KrsController::class);

        /* Nilai */
        Route::get('/nilai/export-excel', [NilaiController::class, 'exportExcel'])
            ->name('nilai.export-excel');

        Route::get('/nilai/print', [NilaiController::class, 'print'])
            ->name('nilai.print');

        Route::resource('nilai', NilaiController::class);

        /* Transkrip */
        Route::get('/transkrip', [TranskripController::class, 'index'])
            ->name('transkrip.index');

        Route::get('/transkrip/{mahasiswa}', [TranskripController::class, 'show'])
            ->name('transkrip.show');

        Route::get('/transkrip/{mahasiswa}/print', [TranskripController::class, 'print'])
            ->name('transkrip.print');

    });

});

require __DIR__ . '/auth.php';