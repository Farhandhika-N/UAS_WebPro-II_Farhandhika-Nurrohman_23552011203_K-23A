<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Matakuliah;
use App\Models\Krs;
use App\Models\Nilai;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data user yang sedang login
        $user = Auth::user();

        // 1. Counter Utama (Highlight Angka Penting)
        $jumlahJurusan    = Jurusan::count();
        $jumlahMahasiswa  = Mahasiswa::count();
        $jumlahDosen      = Dosen::count();
        $jumlahMatakuliah = Matakuliah::count();
        $jumlahKrs        = Krs::count();
        $jumlahNilai      = Nilai::count();

        // 2. Data Terbaru untuk Tabel & Timeline
        $mahasiswaTerbaru = Mahasiswa::with('jurusan')->latest()->take(5)->get();
        $nilaiTerbaru     = Nilai::with(['krs.mahasiswa', 'matakuliah'])->latest()->take(5)->get();
        $krsTerbaru       = Krs::with('mahasiswa')->latest()->take(3)->get();

        // 3. Pie Chart: Proporsi Mahasiswa per Jurusan
        $jurusanChart = Jurusan::withCount('mahasiswas')->get();

        // 4. Bar Chart: Jumlah Mahasiswa Per Angkatan
        $angkatanChart = Mahasiswa::select(DB::raw('SUBSTRING(nim, 1, 4) as tahun'), DB::raw('count(*) as total'))
            ->groupBy('tahun')
            ->orderBy('tahun', 'asc')
            ->get();

        // 5. BAR CHART: Distribusi Pengisian KRS per Semester
        $krsPerSemester = Krs::select('semester', DB::raw('count(*) as total'))
            ->groupBy('semester')
            ->orderBy('semester', 'asc')
            ->get();

        // 6. HIGHLIGHT UTAMA: Kelulusan Mahasiswa (A, B, C = Lulus | D = Tidak Lulus)
        $lulus = Nilai::whereIn('nilai_huruf', ['A', 'B', 'C'])->count();
        $tidakLulus = Nilai::where('nilai_huruf', 'D')->count();
        
        $rasioKelulusan = [
            'Lulus' => $lulus,
            'Tidak_Lulus' => $tidakLulus
        ];

        // 7. KONDISIONAL ROLE: Sinkronisasi Activity Log (Khusus Admin)
        $recentLogs = collect();
        if ($user && $user->role === 'admin') {
            $recentLogs = ActivityLog::with('user')
                ->latest()
                ->take(5) 
                ->get();
        }

        return view('dashboard', compact(
            'jumlahJurusan', 
            'jumlahMahasiswa', 
            'jumlahDosen', 
            'jumlahMatakuliah',
            'jumlahKrs',
            'jumlahNilai',
            'mahasiswaTerbaru',
            'nilaiTerbaru',
            'krsTerbaru',
            'jurusanChart',
            'angkatanChart',
            'krsPerSemester',
            'rasioKelulusan',
            'recentLogs'
        ));
    }
}