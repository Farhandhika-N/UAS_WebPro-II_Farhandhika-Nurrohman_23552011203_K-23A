<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Services\ActivityLogger;

class MatakuliahController extends Controller
{
    public function index(Request $request)
    {
        $query = Matakuliah::with('jurusan');

        if ($request->has('search')) {
            $query->where('nama_matakuliah', 'like', '%' . $request->search . '%');
        }

        $matakuliahs = $query->paginate(10);
        return view('matakuliah.index', compact('matakuliahs'));
    }

    public function create()
    {
    $jurusans = Jurusan::all();
    $dosens = Dosen::all();

    return view(
        'matakuliah.create',
        compact('jurusans','dosens')
    );
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'nama_matakuliah' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
            'id_jurusan' => 'required|exists:jurusans,id_jurusan',
            'id_dosen' => 'nullable|exists:dosens,id_dosen',
        ]);

        Matakuliah::create($request->all());
        ActivityLogger::log(
            'Menambahkan data matakuliah',
            'Matakuliah',
            'CREATE'
        );
        return redirect()->route('matakuliah.index')->with('success', 'Matakuliah berhasil ditambahkan.');
    }

    public function edit(Matakuliah $matakuliah)
    {
        $jurusans = Jurusan::all();
        $dosens = Dosen::all();
        return view('matakuliah.edit', compact('matakuliah', 'jurusans', 'dosens'));
    }

    public function update(Request $request, Matakuliah $matakuliah)
    {
        $request->validate([
            'nama_matakuliah' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
            'id_jurusan' => 'required|exists:jurusans,id_jurusan',
            'id_dosen' => 'nullable|exists:dosens,id_dosen',
        ]);

        $matakuliah->update($request->all());
        ActivityLogger::log(
            'Memperbarui data matakuliah',
            'Matakuliah',
            'UPDATE'
        );
        return redirect()->route('matakuliah.index')->with('success', 'Matakuliah berhasil diperbarui.');
    }

    public function destroy(Matakuliah $matakuliah)
    {
        $matakuliah->delete();
        ActivityLogger::log(
            'Menghapus data matakuliah',
            'Matakuliah',
            'DELETE'
        );
        return redirect()->route('matakuliah.index')->with('success', 'Matakuliah berhasil dihapus.');
    }
    public function print()
    {
        $matakuliahs = Matakuliah::with('jurusan')->get();
        return view('matakuliah.print', compact('matakuliahs'));
    }

    public function exportExcel()
    {
        $matakuliahs = Matakuliah::with('jurusan')->get();

        return response()
            ->view('matakuliah.excel', compact('matakuliahs'))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="matakuliah.xls"');
    }
}