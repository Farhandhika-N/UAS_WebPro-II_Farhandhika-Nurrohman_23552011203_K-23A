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

.text-sub {
    color: #94a3b8 !important;
    font-size: 0.8rem;
}

/* BADGES */
.badge-angka {
    background: rgba(14, 165, 233, 0.15);
    color: #0ea5e9;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

.badge-grade {
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    display: inline-block;
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

<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Data Nilai</h4>
        <p>Kelola dan tinjau pencapaian nilai akademik mahasiswa</p>
    </div>

    <div class="d-flex align-items-center" style="gap:8px;">
        <a href="{{ route('nilai.export-excel') }}"
           class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i>
            Export Excel
        </a>

        <a href="{{ route('nilai.print') }}"
           target="_blank"
           class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i>
            Export PDF
        </a>

        <a href="{{ route('nilai.create') }}"
           class="btn btn-add">
            <i class="bi bi-plus-lg"></i>
            Tambah Nilai
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
        placeholder="Cari mahasiswa...">

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
                    <th>Mahasiswa</th>
                    <th>Matakuliah</th>
                    <th>Nilai Angka</th>
                    <th>Nilai Huruf</th>
                    <th width="200" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($nilais as $nilai)
                <tr>
                    <td class="text-light-muted small">{{ $nilais->firstItem() + $loop->index }}</td>
                    
                    <td>
                        <div class="fw-semibold text-white">{{ $nilai->krs->mahasiswa->nama }}</div>
                        <small class="text-sub d-block mt-0.5 font-monospace">
                            {{ $nilai->krs->mahasiswa->nim }}
                        </small>
                    </td>
                    
                    <td>
                        <div class="text-white">{{ $nilai->matakuliah->nama_matakuliah }}</div>
                        <small class="text-sub d-block mt-0.5 font-monospace">
                            {{ $nilai->matakuliah->kode_matakuliah }}
                        </small>
                    </td>
                    
                    <td>
                        <span class="badge-angka">{{ $nilai->nilai_angka }}</span>
                    </td>
                    
                    <td>
                        @php
                            switch($nilai->nilai_huruf){
                                case 'A':
                                    $bgGrade = 'rgba(34, 197, 94, 0.15)';
                                    $textGrade = '#22c55e';
                                    break;
                                case 'B':
                                    $bgGrade = 'rgba(59, 130, 246, 0.15)';
                                    $textGrade = '#3b82f6';
                                    break;
                                case 'C':
                                    $bgGrade = 'rgba(245, 158, 11, 0.15)';
                                    $textGrade = '#f59e0b';
                                    break;
                                default:
                                    $bgGrade = 'rgba(239, 68, 68, 0.15)';
                                    $textGrade = '#ef4444';
                            }
                        @endphp
                        <span class="badge-grade" style="background: {{ $bgGrade }}; color: {{ $textGrade }};">
                            {{ $nilai->nilai_huruf }}
                        </span>
                    </td>
                    
                    <td>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('nilai.edit', $nilai->id_nilai) }}" class="btn btn-action btn-edit">
                                <i class="bi bi-pencil"></i> Edit
                            </a>

                            <form action="{{ route('nilai.destroy', $nilai->id_nilai) }}" method="POST" class="delete-form d-inline">
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
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="bi bi-folder-x fs-1 d-block mb-2"></i>
                            <p class="mb-0">Belum ada data nilai dalam database</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    @if($nilais->hasPages())
    <div class="mt-4 d-flex justify-content-end">
        {{ $nilais->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

@endsection