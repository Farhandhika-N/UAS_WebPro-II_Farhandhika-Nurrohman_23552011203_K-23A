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

/* BADGE */
.badge-sks {
    background: rgba(59,130,246,0.15);
    color: #3b82f6;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

/* JURUSAN DINAMIS */
.badge-jurusan {
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    color: white;
}

/* BUTTON */
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

/* ACTION */
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

/* SEARCH */
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

/* EMPTY */
.empty-state {
    text-align: center;
    padding: 30px;
    color: #64748b;
}
</style>

{{-- HEADER --}}
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Data Matakuliah</h4>
        <p>Kelola data matakuliah dalam sistem akademik</p>
    </div>

    <div class="d-flex align-items-center" style="gap:8px;">
        <a href="{{ route('matakuliah.export-excel') }}" class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i> Export Excel
        </a>

        <a href="{{ route('matakuliah.print') }}" target="_blank" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>

        <a href="{{ route('matakuliah.create') }}" class="btn btn-add">
            <i class="bi bi-plus-lg"></i> Tambah Matakuliah
        </a>
    </div>
</div>

{{-- ALERT --}}
@if(session('success'))
    <div class="alert alert-success border-0 mb-4" style="border-radius: 12px; background-color: rgba(16, 185, 129, 0.2) !important; color: #34d399 !important;">
        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
    </div>
@endif

{{-- SEARCH SYSTEM (Diselaraskan ukurannya dengan form pencarian data dosen & mahasiswa) --}}
<form method="GET" class="mb-4 d-flex gap-2" style="max-width: 450px; width: 100%;">
    <input type="text" name="search"
        value="{{ request('search') }}"
        class="form-control search-box"
        placeholder="Cari matakuliah..."
        style="padding: 5px 12px; font-size: 0.9rem;">

    <button type="submit" class="btn btn-add text-nowrap d-inline-flex align-items-center justify-content-center gap-2"
        style="padding: 5px 16px !important; font-size: 0.9rem; border-radius: 10px;">
        <i class="bi bi-search"></i> 
        <span>Cari</span>
    </button>
</form>

{{-- MAPPING WARNA --}}
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

foreach(\App\Models\Jurusan::all() as $j){
    $jurusanColors[$j->id_jurusan] = $colors[$i % count($colors)];
    $i++;
}
@endphp

{{-- TABLE --}}
<div class="card-table">
    <div class="table-responsive">
        <table class="table-custom align-middle">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Nama Matakuliah</th>
                    <th>SKS</th>
                    <th>Jurusan</th>
                    <th>Dosen</th>
                    <th width="200" class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($matakuliahs as $index => $mk)
                <tr>
                    <td class="text-light-muted small">{{ $matakuliahs->firstItem() + $index }}</td>

                    <td class="fw-semibold text-white">
                        {{ $mk->nama_matakuliah }}
                    </td>

                    <td>
                        <span class="badge-sks text-nowrap">
                            {{ $mk->sks }} SKS
                        </span>
                    </td>

                    <td>
                        <span class="badge-jurusan text-nowrap"
                              style="background: {{ $jurusanColors[$mk->id_jurusan] ?? '#64748b' }}">
                            {{ $mk->jurusan->nama_jurusan }}
                        </span>
                    </td>

                    <td class="text-nowrap text-light-muted small">
                        {{ $mk->dosen ? $mk->dosen->nama_dosen : 'Tidak ada dosen' }}
                    </td>

                    <td>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('matakuliah.edit', $mk->id_matakuliah) }}"
                               class="btn btn-action btn-edit text-nowrap">
                                <i class="bi bi-pencil"></i> Edit
                            </a>

                            <form action="{{ route('matakuliah.destroy', $mk->id_matakuliah) }}" method="POST" class="delete-form d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-action btn-delete text-nowrap">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state py-5">
                            <i class="bi bi-journal-bookmark fs-1 d-block mb-2 text-muted"></i>
                            <p class="mb-0">Data matakuliah belum tersedia</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    @if($matakuliahs->hasPages())
    <div class="mt-4 d-flex justify-content-end">
        {{ $matakuliahs->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

@endsection