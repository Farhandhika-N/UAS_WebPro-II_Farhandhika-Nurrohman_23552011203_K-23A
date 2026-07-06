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

.text-light-muted {
    color: #ffffff !important;
}

/* BADGES */
.badge-smt {
    background: rgba(59, 130, 246, 0.15);
    color: #3b82f6;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

.badge-ta {
    background: rgba(34, 197, 94, 0.15);
    color: #22c55e;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

.badge-mk-soft {
    background: rgba(71, 85, 105, 0.4);
    color: #cbd5e1;
    border: 1px solid #475569;
    padding: 5px 10px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 500;
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
        <h4 class="mb-1">Data KRS</h4>
        <p>Kelola Kartu Rencana Studi Mahasiswa dalam sistem akademik</p>
    </div>

    <div class="d-flex align-items-center" style="gap:8px;">
        <a href="{{ route('krs.export-excel') }}"
           class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i>
            Export Excel
        </a>

        <a href="{{ route('krs.print') }}"
           target="_blank"
           class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i>
            Export PDF
        </a>

        <a href="{{ route('krs.create') }}"
           class="btn btn-add">
            <i class="bi bi-plus-lg"></i>
            Tambah KRS
        </a>
    </div>
</div>

{{-- ALERT --}}
@if(session('success'))
    <div class="alert alert-success border-0 mb-4" style="border-radius: 12px; background-color: rgba(16, 185, 129, 0.2) !important; color: #34d399 !important;">
        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
    </div>
@endif

{{-- SEARCH --}}
<form method="GET" class="mb-3 d-flex gap-2" style="max-width: 450px;">
    <input type="text" name="search"
        value="{{ request('search') }}"
        class="form-control search-box"
        placeholder="Cari Nama / NIM...">

    <div class="col-md-4">
        <button class="btn btn-add w-100 h-100">
            <i class="bi bi-search me-1"></i> Cari
        </button>
    </div>
</form>

{{-- TABLE CARD --}}
<div class="card-table">
    <div class="table-responsive">
        <table class="table-custom align-middle">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>NIM</th>
                    <th>Mahasiswa</th>
                    <th>Jurusan</th>
                    <th>Semester</th>
                    <th>Tahun</th>
                    <th>Matakuliah</th>
                    <th width="200" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($krs as $item)
                <tr>
                    <td class="text-light-muted small">{{ $krs->firstItem() + $loop->index }}</td>
                    <td class="text-info font-monospace small fw-bold">{{ $item->mahasiswa->nim }}</td>
                    <td class="fw-semibold text-white">{{ $item->mahasiswa->nama }}</td>
                    <td>{{ $item->mahasiswa->jurusan->nama_jurusan }}</td>
                    
                    <td>
                        <span class="badge-smt text-nowrap">Semester {{ $item->semester }}</span>
                    </td>
                    
                    <td>
                        <span class="badge-ta text-nowrap">{{ $item->tahun_ajaran }}</span>
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-1">
                            @forelse($item->nilais as $nilai)
                                @if($nilai->matakuliah)
                                    <span class="badge badge-mk-soft">
                                        {{ $nilai->matakuliah->nama_matakuliah }} <span class="text-info">({{ $nilai->matakuliah->sks }} SKS)</span>
                                    </span>
                                @endif
                            @empty
                                <span class="text-light-muted small italic">Belum ambil MK</span>
                            @endforelse
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('krs.edit', $item->id_krs) }}" class="btn btn-action btn-edit">
                                <i class="bi bi-pencil"></i> Edit
                            </a>

                            <form action="{{ route('krs.destroy', $item->id_krs) }}" method="POST" class="delete-form d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-action btn-delete">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <i class="bi bi-folder-x fs-1 d-block mb-2"></i>
                            <p class="mb-0">Belum ada data KRS dalam database</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    @if($krs->hasPages())
    <div class="mt-4 d-flex justify-content-end">
        {{ $krs->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

@endsection