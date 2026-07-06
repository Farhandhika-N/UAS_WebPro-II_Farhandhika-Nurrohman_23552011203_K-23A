<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Nilai;
use Illuminate\Http\Request;

class TranskripController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $mahasiswa = Mahasiswa::with('jurusan')
            ->when($search, function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            })
            ->first();

        $nilais = collect();

        if ($mahasiswa) {
            $nilais = Nilai::whereHas('krs', function($q) use ($mahasiswa) {
                $q->where('id_mahasiswa', $mahasiswa->id_mahasiswa);
            })->with('matakuliah')->get();
        }

        return view('transkrip.index', compact('mahasiswa', 'nilais'));
    }

    public function print($id_mahasiswa)
    {
        $mahasiswa = Mahasiswa::with('jurusan')->findOrFail($id_mahasiswa);

        $nilais = Nilai::whereHas('krs', function($q) use ($mahasiswa) {
            $q->where('id_mahasiswa', $mahasiswa->id_mahasiswa);
        })->with('matakuliah')->get();

        return view('transkrip.print', compact('mahasiswa', 'nilais'));
    }
}