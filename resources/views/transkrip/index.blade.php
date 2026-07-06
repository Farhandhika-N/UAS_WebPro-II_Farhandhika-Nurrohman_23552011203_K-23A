@extends('layouts.app')

@section('content')
<style>
body { 
    background: #0f172a; 
    font-family: 'Inter', sans-serif; 
}
.page-header h4 { 
    font-weight: 700; 
    color: #fff; 
}
.card-table { 
    background: #1e293b; 
    border-radius: 16px; 
    border: 1px solid #334155; 
    padding: 24px; 
}
.table-custom { 
    width: 100%; 
    color: #e2e8f0; 
}
.table-custom thead th { 
    font-size: 0.75rem; 
    text-transform: uppercase; 
    color: #94a3b8; 
    border-bottom: 2px solid #334155; 
    padding: 14px 12px; 
    letter-spacing: 0.5px;
}
.table-custom td { 
    padding: 14px 12px; 
    border-top: 1px solid #334155; 
}
.table-custom tbody tr:hover {
    background: #243146;
}
.text-light-muted { 
    color: #94a3b8 !important; 
}

.search-wrapper {
    max-width: 500px;
}


.search-box {
    background: #020617;
    border: 1px solid #334155;
    color: white;
    border-radius: 12px;
    padding: 12px 16px;
    height: 48px;
    font-size: 0.9rem;
    width: 100%;
}

.search-box:focus {
    background: #020617;
    color: white;
    border-color: #3b82f6;
    box-shadow: none;
}

.btn-search {
    background: #3b82f6;
    border: none;
    border-radius: 12px;
    padding: 0 24px;
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    height: 48px;
    white-space: nowrap;
    transition: 0.2s;
}

.btn-search:hover {
    background: #2563eb;
    color: white;
    transform: translateY(-1px);
}

/* COMPONENT CARD SUMMARY & BADGES */
.card-summary { 
    background: #1e293b; 
    border: 1px solid #334155; 
    border-radius: 16px; 
    padding: 20px; 
    color: white; 
    height: 100%;
}
.badge-soft {
    background: rgba(59, 130, 246, 0.15);
    color: #60a5fa;
    padding: 6px 12px;
    border-radius: 10px;
    font-size: 0.8rem;
}

.btn-print {
    background: #ef4444;
    border: none;
    border-radius: 10px;
    padding: 10px 18px;
    color: white;
    font-weight: 500;
    font-size: 0.9rem;
    transition: 0.2s;
}
.btn-print:hover {
    background: #dc2626;
    color: white;
}
</style>

{{-- HEADER UTAMA --}}
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4>Transkrip Nilai</h4>
        <p class="text-light-muted mb-0">Kumulatif seluruh nilai matakuliah yang telah ditempuh</p>
    </div>
    @if($mahasiswa)
    <a href="{{ route('transkrip.print', ['mahasiswa' => $mahasiswa->id_mahasiswa]) }}" target="_blank" class="btn btn-print">
        <i class="bi bi-file-earmark-pdf me-2"></i> Cetak Transkrip
    </a>
    @endif
</div>

{{-- FORM PENCARIAN --}}
<form method="GET" class="mb-4">
    <div class="d-flex gap-2 search-wrapper">
        <div class="flex-grow-1">
            <input type="text" 
                   name="search" 
                   class="form-control search-box " 
                   placeholder="Masukkan Nama/NIM Mahasiswa..." 
                   value="{{ request('search') }}">
        </div>
        
        <button type="submit" class="btn btn-search d-flex align-items-center gap-2">
            <i class="bi bi-search me-1"></i> Cari
        </button>
    </div>
</form>
@if($mahasiswa)
{{-- RINGKASAN PROFIL & STATISTIK IPK --}}
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card-summary">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="text-info fw-bold mb-0 text-uppercase tracking-wider" style="font-size: 0.8rem;">Biodata Mahasiswa</h6>
                <span class="badge-soft text-info" style="background: rgba(6, 182, 212, 0.15);">Aktif</span>
            </div>
            <div class="mb-2" style="font-size: 1.05rem;">Nama: <strong class="text-white">{{ $mahasiswa->nama }}</strong></div>
            <div class="small text-light-muted font-monospace mb-1">NIM: {{ $mahasiswa->nim }}</div>
            <div class="small text-light-muted">Jurusan: {{ $mahasiswa->jurusan->nama_jurusan }}</div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card-summary d-flex flex-column justify-content-center align-items-center text-center">
            @php
                $totalSks = 0;
                $totalBobot = 0;
                foreach($nilais as $n) {
                    $sks = $n->matakuliah->sks;
                    $totalSks += $sks;
                    
                    $bobot = 0;
                    if($n->nilai_huruf == 'A') $bobot = 4;
                    elseif($n->nilai_huruf == 'B') $bobot = 3;
                    elseif($n->nilai_huruf == 'C') $bobot = 2;
                    
                    $totalBobot += ($bobot * $sks);
                }
                $ipk = $totalSks > 0 ? round($totalBobot / $totalSks, 2) : 0;
            @endphp
            <span class="text-light-muted small text-uppercase font-weight-bold tracking-wide" style="font-size: 0.75rem;">Indeks Prestasi Kumulatif (IPK)</span>
            <h1 class="text-success fw-bold my-1 font-monospace" style="font-size: 3rem;">{{ number_format($ipk, 2) }}</h1>
            <span class="badge-soft mt-1">{{ $totalSks }} Total SKS</span>
        </div>
    </div>
</div>

{{-- TABEL TRANSKRIP --}}
<div class="card-table">
    <div class="table-responsive">
        <table class="table-custom align-middle">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Kode MK</th>
                    <th>Nama Matakuliah</th>
                    <th>SKS</th>
                    <th>Nilai Angka</th>
                    <th>Nilai Huruf</th>
                </tr>
            </thead>
            <tbody>
                @forelse($nilais as $index => $n)
                <tr>
                    <td class="text-light-muted small">{{ $index + 1 }}</td>
                    <td class="text-info font-monospace small">{{ $n->matakuliah->kode_matakuliah }}</td>
                    <td class="fw-semibold text-white">{{ $n->matakuliah->nama_matakuliah }}</td>
                    <td class="text-white-50">{{ $n->matakuliah->sks }}</td>
                    <td><span class="text-white font-monospace">{{ $n->nilai_angka }}</span></td>
                    <td>
                        @php
                            $badgeStyle = 'background: rgba(16, 185, 129, 0.15); color: #10b981;';
                            if($n->nilai_huruf == 'B') $badgeStyle = 'background: rgba(59, 130, 246, 0.15); color: #3b82f6;';
                            if($n->nilai_huruf == 'C') $badgeStyle = 'background: rgba(245, 158, 11, 0.15); color: #f59e0b;';
                            if($n->nilai_huruf == 'D') $badgeStyle = 'background: rgba(239, 68, 68, 0.15); color: #ef4444;';
                        @endphp
                        <span class="fw-bold px-2 py-1 rounded" style="{{ $badgeStyle }}">
                            {{ $n->nilai_huruf }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-light-muted py-4">Belum ada data nilai kumulatif.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection