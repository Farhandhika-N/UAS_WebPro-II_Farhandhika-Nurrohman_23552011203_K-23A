<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanAPI extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::all();

        if (!$jurusan) {
            return response()->json([
                'status' => '404',
                'success' => false,
                'message' => 'Data jurusan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => '200',
            'success' => true,
            'message' => 'Data jurusan berhasil ditemukan',
            'data' => $jurusan
        ], 200);
    }

    public function show($id)
    {
        $jurusan = Jurusan::find($id);

        if (!$jurusan) {
            return response()->json([
                'status' => '404',
                'success' => false,
                'message' => 'Data jurusan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => '200',
            'success' => true,
            'message' => 'Data jurusan berhasil ditemukan',
            'data' => $jurusan
        ], 200);
    }

    public function store(Request $request)
    {
        $jurusan = Jurusan::create($request->all());

        return response()->json([
            'status' => '200',
            'success' => true,
            'message' => 'Data jurusan berhasil dibuat',
            'data' => $jurusan
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $jurusan = Jurusan::find($id);

        if (!$jurusan) {
            return response()->json([
                'success' => false,
                'message' => 'Data jurusan tidak ditemukan'
            ], 404);
        }

        $jurusan->update($request->all());

        return response()->json([
            'status' => '200',
            'success' => true,
            'message' => 'Data jurusan berhasil diperbarui',
            'data' => $jurusan
        ], 200);
    }

    public function destroy($id)
    {
        $jurusan = Jurusan::find($id);

        if (!$jurusan) {
            return response()->json([
                'success' => false,
                'message' => 'Data jurusan tidak ditemukan'
            ], 404);
        }

        $jurusan->delete();

        return response()->json([
            'status' => '200',
            'success' => true,
            'message' => 'Data jurusan berhasil dihapus'
        ], 200);
    }
}