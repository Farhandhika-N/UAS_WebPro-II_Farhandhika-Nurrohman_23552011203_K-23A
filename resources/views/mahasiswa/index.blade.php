@extends('layouts.app')

@section('content')

<style>
body {
    background: #0f172a;
    font-family: 'Inter', sans-serif;
}

/* HEADER */
.page-header h4 {
    font-weight: 700;
    color: #fff;
}

.page-header p {
    color: #94a3b8;
    font-size: 0.85rem;
}

/* CARD */
.card-table {
    background: #1e293b;
    border-radius: 16px;
    border: 1px solid #334155;
    padding: 24px;
}

/* TABLE */
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

/* WARNA TEKS DENGAN TEMA GELAP  */
.text-light-muted {
    color: #ffffff !important;
}

.text-address {
    color: #94a3b8 !important;
    font-size: 0.8rem;
}

/* BADGES */
.badge-jk-l {
    background: rgba(59, 130, 246, 0.15);
    color: #3b82f6;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

.badge-jk-p {
    background: rgba(244, 63, 94, 0.15);
    color: #f43f5e;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

.badge-jurusan {
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    color: white;
}

/* SEARCH SYSTEM */
.search-box {
    background: #020617;
    border: 1px solid #334155;
    color: white;
    border-radius: 10px;
}

.search-box:focus {
    background: #020617;
    color: white;
    border-color: #3b82f6;
    box-shadow: none;
}

/* BUTTONS */
.btn-add {
    background: #3b82f6;
    border: none;
    border-radius: 10px;
    padding: 8px 16px;
    color: white;
}

.btn-add:hover {
    background: #2563eb;
    color: white;
}

/* ACTIONS */
.btn-action {
    border-radius: 8px;
    padding: 6px 12px;
    font-size: 13px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    transition: 0.2s;
}

.btn-action i {
    margin-right: 5px;
}

.btn-edit {
    background: #3b82f6;
    color: white;
    border: none;
}

.btn-edit:hover {
    background: #2563eb;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59,130,246,0.4);
    color: white;
}

.btn-delete {
    background: #ef4444;
    color: white;
    border: none;
}

.btn-delete:hover {
    background: #dc2626;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(239,68,68,0.4);
    color: white;
}

/* EMPTY STATE */
.empty-state {
    text-align: center;
    padding: 30px;
    color: #64748b;
}
</style>

{{-- HEADER --}}
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Data Mahasiswa</h4>
        <p>Kelola seluruh data biodata dan administrasi akademik mahasiswa</p>
    </div>

    <div class="d-flex align-items-center" style="gap:8px;">
        <a href="{{ route('mahasiswa.export-excel') }}" class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i> Export Excel
        </a>

        <a href="{{ route('mahasiswa.print') }}" target="_blank" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>

        @if(Auth::user()->role == 'petugas' || Auth::user()->role == 'admin')
            <a href="{{ route('mahasiswa.create') }}" class="btn btn-add">
                <i class="bi bi-plus-lg"></i> Tambah Mahasiswa
            </a>
        @endif
    </div>
</div>

{{-- ALERT --}}
@if(session('success'))
    <div class="alert alert-success border-0 mb-4" style="border-radius: 12px; background-color: rgba(16, 185, 129, 0.2) !important; color: #34d399 !important;">
        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
    </div>
@endif

{{-- SEARCH & FILTER --}}
<form method="GET" class="mb-4">
    <div class="row g-2" style="max-width: 800px;">
        <div class="col-md-5">
            <input type="text" name="search"
                value="{{ request('search') }}"
                class="form-control search-box h-100"
                placeholder="Cari NIM / Nama..."
                style="padding: 8px 12px; font-size: 0.9rem;">
        </div>
        
        <div class="col-md-4">
            <select name="jurusan" class="form-select search-box h-100" style="padding: 8px 12px; font-size: 0.9rem;">
                <option value="">Semua Jurusan</option>
                @foreach($jurusans as $jurusan)
                    <option value="{{ $jurusan->id_jurusan }}" {{ request('jurusan') == $jurusan->id_jurusan ? 'selected' : '' }}>
                        {{ $jurusan->nama_jurusan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <button class="btn btn-add w-100 h-100 d-inline-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-search"></i> Cari
            </button>
        </div>
    </div>
</form>

{{-- MAPPING JURUSAN COLOR CODES --}}
@php
$colors = [
    '#3b82f6', // biru
    '#22c55e', // hijau
    '#f59e0b', // kuning
    '#ef4444', // merah
    '#8b5cf6', // ungu
    '#06b6d4', // cyan
    '#f43f5e', // pink
];

$jurusanColors = [];
$i = 0;

foreach($jurusans as $j){
    $jurusanColors[$j->id_jurusan] = $colors[$i % count($colors)];
    $i++;
}
@endphp

{{-- TABLE CARD --}}
<div class="card-table">
    <div class="table-responsive">
        <table class="table-custom align-middle">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Angkatan</th>
                    <th>No HP</th>
                    <th>Jurusan</th>
                    @if(Auth::user()->role == 'petugas' || Auth::user()->role == 'admin')
                    <th width="200" class="text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($mahasiswas as $m)
                <tr>
                    <td class="text-light-muted small">{{ $mahasiswas->firstItem() + $loop->index }}</td>
                    
                    <td class="text-info font-monospace small fw-bold text-nowrap">{{ $m->nim }}</td>
                    
                    <td>
                        <div class="fw-semibold text-white">{{ $m->nama }}</div>
                        @if($m->alamat)
                            <small class="text-address d-block mt-1" style="max-width: 250px;">
                                {{ Str::limit($m->alamat, 40) }}
                            </small>
                        @endif
                    </td>
                    
                    <td>
                        @if($m->jenis_kelamin == 'L')
                            <span class="badge-jk-l text-nowrap">Laki-laki</span>
                        @else
                            <span class="badge-jk-p text-nowrap">Perempuan</span>
                        @endif
                    </td>
                    
                    <td class="text-white-50 font-monospace small text-nowrap">{{ $m->angkatan }}</td>
                    <td class="text-light-muted small text-nowrap">{{ $m->no_hp ?? '-' }}</td>
                    
                    <td>
                        <span class="badge-jurusan text-nowrap" style="background: {{ $jurusanColors[$m->id_jurusan] ?? '#64748b' }}">
                            {{ $m->jurusan->nama_jurusan }}
                        </span>
                    </td>
                    
                    @if(Auth::user()->role == 'petugas' || Auth::user()->role == 'admin')
                    <td>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('mahasiswa.edit', $m->id_mahasiswa) }}" class="btn btn-action btn-edit text-nowrap">
                                <i class="bi bi-pencil"></i> Edit
                            </a>

                            <form action="{{ route('mahasiswa.destroy', $m->id_mahasiswa) }}" method="POST" class="delete-form d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-action btn-delete text-nowrap">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ Auth::user()->role == 'petugas' || Auth::user()->role == 'admin' ? 8 : 7 }}">
                        <div class="empty-state">
                            <i class="bi bi-folder-x fs-1 d-block mb-2"></i>
                            <p class="mb-0">Tidak ada data mahasiswa yang ditemukan</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    @if($mahasiswas->hasPages())
    <div class="mt-4 d-flex justify-content-end">
        {{ $mahasiswas->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

@endsection