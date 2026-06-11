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

/* TEXT */
.nim-text {
    color: #38bdf8;
    font-weight: 600;
}

/* BADGE JURUSAN DINAMIS */
.badge-jurusan {
    padding: 6px 14px;
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

/* ACTION BUTTON */
.btn-action {
    border-radius: 8px;
    padding: 6px 12px;
    font-size: 13px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
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
        <h4 class="mb-1">Data Mahasiswa</h4>
        <p>Kelola data mahasiswa dalam sistem akademik</p>
    </div>

    <div class="d-flex gap-2">

        <a href="{{ route('mahasiswa.export-excel') }}"
        class="btn btn-success rounded-3">
        <i class="bi bi-file-earmark-excel"></i>
        Export Excel
        </a>

        <a href="{{ route('mahasiswa.print') }}"
        target="_blank"
        class="btn btn-danger rounded-3">
        <i class="bi bi-file-earmark-pdf"></i>
        Export PDF
        </a>

        <a href="{{ route('mahasiswa.create') }}"
           class="btn btn-add">
            <i class="bi bi-plus-lg"></i>
            Tambah
        </a>

    </div>
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
        placeholder="Cari NIM / Nama...">

    <button class="btn btn-add">Cari</button>
</form>

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
$index = 0;

foreach(\App\Models\Jurusan::all() as $j) {
    $jurusanColors[$j->id_jurusan] = $colors[$index % count($colors)];
    $index++;
}
@endphp

{{-- TABLE --}}
<div class="card-table">
    <div class="table-responsive">
        <table class="table-custom">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Jurusan</th>
                    <th width="200">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($mahasiswas as $m)
                <tr>
                    <td>{{ $mahasiswas->firstItem() + $loop->index }}</td>

                    <td class="nim-text">
                        {{ $m->nim }}
                    </td>

                    <td class="fw-semibold">
                        {{ $m->nama }}
                    </td>

                    <td>
                        <span class="badge-jurusan"
                            style="background: {{ $jurusanColors[$m->id_jurusan] ?? '#64748b' }}">
                            {{ $m->jurusan->nama_jurusan }}
                        </span>
                    </td>

                    <td>
                        <div class="d-flex gap-2">

                            <a href="{{ route('mahasiswa.edit', $m->id_mahasiswa) }}"
                               class="btn btn-action btn-edit">
                                <i class="bi bi-pencil"></i> Edit
                            </a>

                            <form action="{{ route('mahasiswa.destroy', $m->id_mahasiswa) }}" method="POST">
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
                            <i class="bi bi-database fs-1"></i>
                            <p class="mt-2">Data mahasiswa belum tersedia</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-4 d-flex justify-content-end">
        {{ $mahasiswas->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection