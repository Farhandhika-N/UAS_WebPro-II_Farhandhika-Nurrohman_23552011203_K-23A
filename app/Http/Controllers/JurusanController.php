<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::paginate(10);
        return view('jurusan.index', compact('jurusans'));
    }

    public function create()
    {
        return view('jurusan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'akreditasi' => 'required|in:A,B,C,Baik,Sangat Baik,Unggul'
        ]);

        Jurusan::create($request->all());
        ActivityLogger::log(
            'Menambah Jurusan',
            'Jurusan',
            'CREATE'
        );
        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function edit(Jurusan $jurusan)
    {
        return view('jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'akreditasi' => 'required|in:A,B,C,Baik,Sangat Baik,Unggul'
        ]);

        $jurusan->update($request->all());
        ActivityLogger::log(
            'Mengupdate Jurusan',
            'Jurusan',
            'UPDATE'
        );
        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function destroy(Jurusan $jurusan)
    {
        ActivityLogger::log(
            'Menghapus Jurusan',
            'Jurusan',
            'DELETE'
        );
        $jurusan->delete();
        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil dihapus.');
    }

    public function print()
    {
        $jurusans = Jurusan::all();
        return view('jurusan.print', compact('jurusans'));
    }

    public function exportExcel()
    {
        $jurusans = Jurusan::all();

        return response()
            ->view('jurusan.excel', compact('jurusans'))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="jurusan.xls"');
    }
}