<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $nilais = Nilai::with([
                'krs.mahasiswa',
                'matakuliah'
            ])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('krs.mahasiswa', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                      ->orWhere('nim', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('nilai.index', compact('nilais'));
    }

    public function create()
    {
        $krs_list = \App\Models\Krs::with('mahasiswa')->get();
        
        $matakuliahs = \App\Models\Matakuliah::orderBy('nama_matakuliah', 'asc')->get();

        return view('nilai.create', compact('krs_list', 'matakuliahs'));
    }

    public function store(Request $request)
    {
        // 1. Validasi data yang masuk dari form
        $request->validate([
            'id_krs' => [
                'required',
                'exists:krs,id_krs',
                // Mencegah duplikasi kombinasi id_krs & id_matakuliah
                \Illuminate\Validation\Rule::unique('nilais')->where(function ($query) use ($request) {
                    return $query->where('id_matakuliah', $request->id_matakuliah);
                }),
            ],
            'id_matakuliah' => 'required|exists:matakuliahs,id_matakuliah',
            'nilai_angka'   => 'required|numeric|min:0|max:100',
        ], [
            'id_krs.unique' => 'Mahasiswa ini sudah memiliki nilai untuk mata kuliah tersebut!',
        ]);

        // 2. Logika konversi nilai angka ke huruf
        $nilai_angka = $request->nilai_angka;
        if ($nilai_angka >= 85) {
            $huruf = 'A';
        } elseif ($nilai_angka >= 70) {
            $huruf = 'B';
        } elseif ($nilai_angka >= 55) {
            $huruf = 'C';
        } else {
            $huruf = 'D';
        }

        // 3. Simpan ke database jika lolos validasi
        Nilai::create([
            'id_krs'        => $request->id_krs,
            'id_matakuliah' => $request->id_matakuliah,
            'nilai_angka'   => $nilai_angka,
            'nilai_huruf'   => $huruf,
        ]);

        ActivityLogger::log(
            'Menambah data nilai',
            'Nilai',
            'CREATE'
        );

        return redirect()
            ->route('nilai.index')
            ->with('success', 'Data nilai berhasil ditambahkan.');
    }

public function edit(Nilai $nilai)
    {
        $krs = \App\Models\Krs::join('mahasiswas', 'krs.id_mahasiswa', '=', 'mahasiswas.id_mahasiswa')
            ->orderBy('mahasiswas.nama', 'asc')
            ->select('krs.*')
            ->with('mahasiswa') 
            ->get();

        $matakuliahs = \App\Models\Matakuliah::orderBy('nama_matakuliah', 'asc')->get();

        return view('nilai.edit', compact(
            'nilai',
            'krs',
            'matakuliahs'
        ));
    }

    public function update(Request $request, Nilai $nilai)
    {
        $request->validate([
            'id_krs' => 'required|exists:krs,id_krs',
            'id_matakuliah' => 'required|exists:matakuliahs,id_matakuliah',
            'nilai_angka' => 'required|numeric|min:0|max:100',
        ]);

        $angka = $request->nilai_angka;

        if ($angka >= 85) {
            $huruf = 'A';
        } elseif ($angka >= 75) {
            $huruf = 'B';
        } elseif ($angka >= 65) {
            $huruf = 'C';
        } else {
            $huruf = 'D';
        }

        $nilai->update([
            'id_mahasiswa' => $request->id_mahasiswa,
            'id_matakuliah' => $request->id_matakuliah,
            'nilai_angka' => $angka,
            'nilai_huruf' => $huruf,
        ]);

        ActivityLogger::log(
            'Memperbarui data nilai',
            'Nilai',
            'UPDATE'
        );

        return redirect()
            ->route('nilai.index')
            ->with('success', 'Data nilai berhasil diperbarui.');
    }

    public function destroy(Nilai $nilai)
    {
        $nilai->delete();

        ActivityLogger::log(
            'Menghapus data nilai',
            'Nilai',
            'DELETE'
        );

        return redirect()
            ->route('nilai.index')
            ->with('success', 'Data nilai berhasil dihapus.');
    }

    public function exportExcel()
    {
        $nilais = Nilai::with([
            'krs.mahasiswa',
            'matakuliah'
        ])->get();

        return response()
            ->view('nilai.excel', compact('nilais'))
            ->header(
                'Content-Type',
                'application/vnd.ms-excel'
            )
            ->header(
                'Content-Disposition',
                'attachment; filename="nilai.xls"'
            );
    }

    public function print()
    {
        $nilais = Nilai::with([
            'krs.mahasiswa',
            'matakuliah'
        ])->get();

        return view('nilai.print', compact('nilais'));
    }
}