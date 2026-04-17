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

.id-text {
    color: #cbd5e1;
    font-weight: 500;
    font-size: 0.85rem;
}

/* BADGE AKREDITASI */
.badge-akre {
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

.akre-A {
    background: #22c55e;
    color: #022c22;
}

.akre-B {
    background: #3b82f6;
    color: white;
}

.akre-C {
    background: #f59e0b;
    color: #3b2f00;
}

.btn-add {
    background: #3b82f6;
    border: none;
    border-radius: 10px;
    padding: 8px 16px;
}

.btn-add:hover {
    background: #2563eb;
}

.btn-action {
    border-radius: 8px;
    padding: 6px 12px;
    font-size: 13px;
    font-weight: 500;
    transition: 0.2s;
    display: inline-flex;
    align-items: center;
}

.btn-action i {
    margin-right: 5px;
}

/* EDIT */
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

/* DELETE */
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
        <h4 class="mb-1">Data Jurusan</h4>
        <p>Kelola data jurusan dalam sistem akademik</p>
    </div>

    <a href="{{ route('jurusan.create') }}" class="btn btn-add">
        <i class="bi bi-plus-lg"></i> Tambah
    </a>
</div>

{{-- ALERT --}}
@if(session('success'))
    <div class="mb-3 text-success small">
        ✔ {{ session('success') }}
    </div>
@endif

{{-- TABLE --}}
<div class="card-table">
    <div class="table-responsive">
        <table class="table-custom">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>ID</th>
                    <th>Nama Jurusan</th>
                    <th>Akreditasi</th>
                    <th width="200">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($jurusans as $j)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td class="id-text">
                        {{ $j->id_jurusan }}
                    </td>

                    <td class="fw-semibold">
                        {{ $j->nama_jurusan }}
                    </td>

                    <td>
                        <span class="badge-akre akre-{{ $j->akreditasi }}">
                            {{ $j->akreditasi }}
                        </span>
                    </td>

                    <td>
                        <div class="d-flex gap-2">

                            <a href="{{ route('jurusan.edit', $j->id_jurusan) }}"
                               class="btn btn-action btn-edit">
                                <i class="bi bi-pencil"></i> Edit
                            </a>

                            <form action="{{ route('jurusan.destroy', $j->id_jurusan) }}" method="POST">
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
                            <p class="mt-2">Belum ada data jurusan</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-4 d-flex justify-content-end">
        {{ $jurusans->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection