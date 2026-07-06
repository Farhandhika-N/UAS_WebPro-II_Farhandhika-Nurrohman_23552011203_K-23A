<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

class MahasiswaController extends Controller
{
public function index(Request $request)
    {
// 1. Ambil query dasar untuk Mahasiswa (Disarankan include relasi 'jurusan' agar performa tabel cepat)
    $query = \App\Models\Mahasiswa::with('jurusan');

    // [PERBAIKAN UTAMA] Logika Pencarian berdasarkan Nama ATAU NIM
    // Menggunakan fungsi closure agar query OR tidak merusak filter jurusan
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('nama', 'like', '%' . $search . '%')
              ->orWhere('nim', 'like', '%' . $search . '%');
        });
    }

    // 2. Filter Berdasarkan Jurusan (Tetap mempertahankan kode lama Anda)
    if ($request->has('jurusan') && $request->jurusan != '') {
        $query->where('id_jurusan', $request->jurusan);
    }

    // Ambil data mahasiswa dengan pagination (membawa parameter request search & jurusan di link page-nya)
    $mahasiswas = $query->paginate(10)->withQueryString();

    // 3. AMBIL SEMUA DATA JURUSAN 
    $jurusans = \App\Models\Jurusan::orderBy('nama_jurusan', 'asc')->get();

    // 4. Kirim kedua variabel ($mahasiswas dan $jurusans) ke view
    return view('mahasiswa.index', compact('mahasiswas', 'jurusans'));
    }
    public function create()
    {
        $jurusans = \App\Models\Jurusan::all();
        return view('mahasiswa.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim'             => 'required|numeric|unique:mahasiswas,nim',
            'nama'            => 'required|max:255',
            'jenis_kelamin'   => 'required|in:L,P',
            'alamat'          => 'nullable',
            'no_hp'           => 'nullable|max:20',
            'angkatan'        => 'required|digits:4',
            'id_jurusan'      => 'required|exists:jurusans,id_jurusan'
        ]);

        Mahasiswa::create($request->all());

        ActivityLogger::log(
            'Menambahkan data mahasiswa',
            'Mahasiswa',
            'CREATE'
        );

        return redirect()
                ->route('mahasiswa.index')
                ->with('success','Data Mahasiswa berhasil ditambahkan.');
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        $jurusans = \App\Models\Jurusan::all();
        return view('mahasiswa.edit', compact('mahasiswa', 'jurusans'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
                'nim'             => 'required|numeric|unique:mahasiswas,nim,'.$mahasiswa->id_mahasiswa.',id_mahasiswa',
                'nama'            => 'required|max:255',
                'jenis_kelamin'   => 'required|in:L,P',
                'alamat'          => 'nullable',
                'no_hp'           => 'nullable|max:20',
                'angkatan'        => 'required|digits:4',
                'id_jurusan'      => 'required|exists:jurusans,id_jurusan'
            ]);

        $mahasiswa->update($request->all());

        ActivityLogger::log(
            'Memperbarui data mahasiswa',
            'Mahasiswa',
            'UPDATE'
        );

        return redirect()
                ->route('mahasiswa.index')
                ->with('success','Data Mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();

        ActivityLogger::log(
            'Menghapus data mahasiswa',
            'Mahasiswa',
            'DELETE'
        );

        return redirect()->route('mahasiswa.index')->with('success', 'Data Mahasiswa berhasil dihapus.');
    }

    public function exportCsv()
    {
        $fileName = 'mahasiswas.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename={$fileName}",
        ];

        $callback = function () {

            $file = fopen('php://output', 'w');

            // UTF-8 BOM
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'ID',
                'NIM',
                'Nama',
                'Jenis Kelamin',
                'No HP',
                'Angkatan',
                'Jurusan'
            ]);

            $mahasiswas = \App\Models\Mahasiswa::with('jurusan')->get();

            foreach ($mahasiswas as $item) {
                fputcsv($file, [
                    $item->id_mahasiswa,
                    $item->nim,
                    $item->nama,
                    $item->jenis_kelamin,
                    $item->no_hp,
                    $item->angkatan,
                    $item->jurusan->nama_jurusan
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function print()
{
    $mahasiswas = \App\Models\Mahasiswa::with('jurusan')->get();
    
    return view('mahasiswa.print', compact('mahasiswas')); 
}
    public function exportExcel()
    {
        $mahasiswas = \App\Models\Mahasiswa::with('jurusan')->get();

        return response()
            ->view('mahasiswa.excel', compact('mahasiswas'))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="mahasiswa.xls"');
    }
}