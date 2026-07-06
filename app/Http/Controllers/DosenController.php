<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

class DosenController extends Controller
{
    public function index(Request $request)
    {
        $query = Dosen::query();

        if ($request->filled('search')) {
            $query->where('nama_dosen','like','%'.$request->search.'%')
                  ->orWhere('nidn','like','%'.$request->search.'%');
        }

        $dosens = $query->paginate(10);

        return view('dosen.index', compact('dosens'));
    }

    public function create()
    {
        return view('dosen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nidn'=>'required|numeric|unique:dosens,nidn',
            'nama_dosen'=>'required|max:255',
            'email'=>'required|email|unique:dosens,email',
            'no_hp'=>'required|max:20',
            'alamat'=>'required|max:255'
        ]);

        Dosen::create($request->all());

        ActivityLogger::log(
            'Menambahkan data dosen',
            'Dosen',
            'CREATE'
        );

        return redirect()
            ->route('dosen.index')
            ->with('success','Data dosen berhasil ditambahkan.');
    }

    public function edit(Dosen $dosen)
    {
        return view('dosen.edit',compact('dosen'));
    }

    public function update(Request $request,Dosen $dosen)
    {
        $request->validate([
            'nidn'=>'required|numeric|unique:dosens,nidn,'.$dosen->id_dosen.',id_dosen',
            'nama_dosen'=>'required|max:255',
            'email'=>'required|email|unique:dosens,email,'.$dosen->id_dosen.',id_dosen',
            'no_hp'=>'required|max:20',
            'alamat'=>'required|max:255'
        ]);

        $dosen->update($request->all());
        ActivityLogger::log(
            'Memperbarui data dosen',
            'Dosen',
            'UPDATE'
        );
        return redirect()
            ->route('dosen.index')
            ->with('success','Data dosen berhasil diperbarui.');
    }

    public function destroy(Dosen $dosen)
    {
        $dosen->delete();

        ActivityLogger::log(
            'Menghapus data dosen',
            'Dosen',
            'DELETE'
        );

        return redirect()
            ->route('dosen.index')
            ->with('success','Data dosen berhasil dihapus.');
    }

    public function print()
    {
        $dosens = Dosen::all();

        return view('dosen.print',compact('dosens'));
    }

    public function exportExcel()
    {
        $dosens = Dosen::all();

        return response()
            ->view('dosen.excel',compact('dosens'))
            ->header('Content-Type','application/vnd.ms-excel')
            ->header('Content-Disposition','attachment; filename="dosen.xls"');
    }
}