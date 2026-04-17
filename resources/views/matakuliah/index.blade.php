@extends('layouts.app')

@section('content')

<style>
/* HEADER */
.page-header h4 {
    font-weight: 600;
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
    padding: 20px;
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
    border-bottom: 1px solid #334155;
    padding: 12px;
}

.table-custom td {
    padding: 14px 12px;
    border-top: 1px solid #334155;
}

.table-custom tbody tr:hover {
    background: #273449;
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
}

.btn-add:hover {
    background: #2563eb;
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
}

/* SEARCH */
.search-box {
    background: #020617;
    border: 1px solid #334155;
    color: white;
    border-radius: 10px;
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

    <a href="{{ route('matakuliah.create') }}" class="btn btn-add">
        <i class="bi bi-plus-lg"></i> Tambah
    </a>
</div>

{{-- ALERT --}}
@if(session('success'))
    <div class="mb-3 text-success small">
        ✔ {{ session('success') }}
    </div>
@endif

{{-- SEARCH --}}
<form method="GET" class="mb-3 d-flex gap-2">
    <input type="text" name="search"
        value="{{ request('search') }}"
        class="form-control search-box"
        placeholder="Cari matakuliah...">

    <button class="btn btn-add">Cari</button>
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
        <table class="table-custom">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Nama Matakuliah</th>
                    <th>SKS</th>
                    <th>Jurusan</th>
                    <th width="200">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($matakuliahs as $index => $mk)
                <tr>
                    <td>{{ $matakuliahs->firstItem() + $index }}</td>

                    <td class="fw-semibold">
                        {{ $mk->nama_matakuliah }}
                    </td>

                    <td>
                        <span class="badge-sks">
                            {{ $mk->sks }} SKS
                        </span>
                    </td>

                    <td>
                        <span class="badge-jurusan"
                              style="background: {{ $jurusanColors[$mk->id_jurusan] ?? '#64748b' }}">
                            {{ $mk->jurusan->nama_jurusan }}
                        </span>
                    </td>

                    <td>
                        <div class="d-flex gap-2">

                            <a href="{{ route('matakuliah.edit', $mk->id_matakuliah) }}"
                               class="btn btn-action btn-edit">
                                <i class="bi bi-pencil"></i> Edit
                            </a>

                            <form action="{{ route('matakuliah.destroy', $mk->id_matakuliah) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="btn btn-action btn-delete"
                                    onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <i class="bi bi-journal-bookmark fs-1"></i>
                            <p class="mt-2">Data matakuliah belum tersedia</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-4 d-flex justify-content-end">
        {{ $matakuliahs->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection