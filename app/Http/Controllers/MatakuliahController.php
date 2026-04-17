<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use App\Models\Jurusan;
use Illuminate\Http\Request;

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
        return view('matakuliah.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'nama_matakuliah' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
            'id_jurusan' => 'required|exists:jurusans,id_jurusan'
        ]);

        Matakuliah::create($request->all());
        return redirect()->route('matakuliah.index')->with('success', 'Matakuliah berhasil ditambahkan.');
    }

    public function edit(Matakuliah $matakuliah)
    {
        $jurusans = Jurusan::all();
        return view('matakuliah.edit', compact('matakuliah', 'jurusans'));
    }

    public function update(Request $request, Matakuliah $matakuliah)
    {
        $request->validate([
            'nama_matakuliah' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
            'id_jurusan' => 'required|exists:jurusans,id_jurusan'
        ]);

        $matakuliah->update($request->all());
        return redirect()->route('matakuliah.index')->with('success', 'Matakuliah berhasil diperbarui.');
    }

    public function destroy(Matakuliah $matakuliah)
    {
        $matakuliah->delete();
        return redirect()->route('matakuliah.index')->with('success', 'Matakuliah berhasil dihapus.');
    }
}