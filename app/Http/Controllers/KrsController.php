<?php

namespace App\Http\Controllers;

use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

class KrsController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Krs::with(['mahasiswa.jurusan', 'nilais.matakuliah']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('mahasiswa', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        $krs = $query->latest()->paginate(10);

        return view('krs.index', compact('krs'));
    }

    public function create()
    {
        $mahasiswas = \App\Models\Mahasiswa::orderBy('nama', 'asc')->get();
        $matakuliahs = \App\Models\Matakuliah::orderBy('nama_matakuliah', 'asc')->get();

        return view('krs.create', compact('mahasiswas', 'matakuliahs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_mahasiswa' => 'required',
            'semester'     => 'required|integer|min:1|max:14',
            'tahun_ajaran' => 'required',
            'matakuliah'   => 'nullable|array', // Validasi input checkbox mata kuliah
        ]);

        // 1. Simpan data induk ke tabel krs
        $krs = new \App\Models\Krs();
        $krs->id_mahasiswa = $request->id_mahasiswa;
        $krs->semester     = $request->semester;
        $krs->tahun_ajaran = $request->tahun_ajaran;
        $krs->save();

        // 2. Simpan setiap mata kuliah yang dicentang ke tabel nilais
        if ($request->has('matakuliah')) {
            foreach ($request->matakuliah as $id_mk) {
                $nilai = new \App\Models\Nilai();
                $nilai->id_krs        = $krs->id_krs;
                $nilai->id_matakuliah = $id_mk;
                $nilai->nilai_angka   = 0; 
                $nilai->nilai_huruf   = '-';
                $nilai->save();
            }
        }

        ActivityLogger::log(
            'Menambah KRS',
            'KRS',
            'CREATE'
        );

        return redirect()->route('krs.index')->with('success', 'Data KRS dan Mata Kuliah berhasil disimpan!');
    }

public function edit(Krs $kr)
{
    $krs = $kr->load(['nilais']);

    // Ambil data untuk dropdown di form edit
    $mahasiswas = \App\Models\Mahasiswa::orderBy('nama', 'asc')->get();
    $matakuliahs = \App\Models\Matakuliah::orderBy('nama_matakuliah', 'asc')->get();

    return view('krs.edit', compact('krs', 'mahasiswas', 'matakuliahs'));
}

public function update(Request $request, Krs $kr)
    {
        $request->validate([
            'id_mahasiswa' => 'required',
            'semester'     => 'required|integer|min:1|max:14',
            'tahun_ajaran' => 'required',
            'matakuliah'   => 'nullable|array',
        ]);

        // 1. Update data induk KRS
        $kr->id_mahasiswa = $request->id_mahasiswa;
        $kr->semester     = $request->semester;
        $kr->tahun_ajaran = $request->tahun_ajaran;
        $kr->save();

        // 2. Proses Sinkronisasi Mata Kuliah:
        \App\Models\Nilai::where('id_krs', $kr->id_krs)->delete();

        // Simpan ulang mata kuliah baru yang sedang dicentang
        if ($request->has('matakuliah')) {
            foreach ($request->matakuliah as $id_mk) {
                $nilai = new \App\Models\Nilai();
                $nilai->id_krs        = $kr->id_krs;
                $nilai->id_matakuliah = $id_mk;
                $nilai->nilai_angka   = 0;
                $nilai->nilai_huruf   = '-';
                $nilai->save();
            }
        }

        ActivityLogger::log(
            'Memperbarui KRS',
            'KRS',
            'UPDATE'
        );

        return redirect()->route('krs.index')->with('success', 'Data KRS berhasil diperbarui!');
    }

    public function destroy(Krs $kr)
    {
        $kr->delete();

        ActivityLogger::log(
            'Menghapus KRS',
            'KRS',
            'DELETE'
        );

        return redirect()
            ->route('krs.index')
            ->with(
                'success',
                'KRS berhasil dihapus'
            );
    }

public function exportExcel()
    {
        $krs = \App\Models\Krs::with(['mahasiswa.jurusan', 'nilais.matakuliah'])->latest()->get();

        header("Content-Type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Data_KRS_Mahasiswa.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo '<table border="1">';
        echo '<thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mahasiswa</th>
                    <th>NIM</th>
                    <th>Jurusan</th>
                    <th>Semester</th>
                    <th>Tahun Ajaran</th>
                    <th>Mata Kuliah Terpilih</th>
                </tr>
              </thead>';
        echo '<tbody>';
        
        foreach ($krs as $index => $item) {
            $list_mk = [];
            if ($item->nilais) {
                foreach ($item->nilais as $nilai) {
                    if ($nilai->matakuliah) {
                        $list_mk[] = $nilai->matakuliah->nama_matakuliah . ' (' . $nilai->matakuliah->sks . ' SKS)';
                    }
                }
            }
            $tampil_mk = count($list_mk) > 0 ? implode(', ', $list_mk) : '-';

            echo '<tr>';
            echo '<td>' . ($index + 1) . '</td>';
            echo '<td>' . ($item->mahasiswa->nama ?? '-') . '</td>';
            echo '<td>' . ($item->mahasiswa->nim ?? '-') . '</td>';
            echo '<td>' . ($item->mahasiswa->jurusan->nama_jurusan ?? '-') . '</td>';
            echo '<td>Semester ' . ($item->semester ?? '-') . '</td>';
            echo '<td>' . ($item->tahun_ajaran ?? '-') . '</td>';
            echo '<td>' . $tampil_mk . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        exit;
    }

public function print()
    {
        $krs = \App\Models\Krs::with(['mahasiswa.jurusan', 'nilais.matakuliah'])->latest()->get();
        
        return view('krs.print', compact('krs'));
    }
}