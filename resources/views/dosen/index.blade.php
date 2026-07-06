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

.text-email {
    color: #94a3b8 !important;
}

/* BADGE CUSTOM DOSEN */
.badge-nidn {
    background: rgba(99, 102, 241, 0.15);
    color: #818cf8;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    font-family: 'JetBrains Mono', 'Fira Code', monospace;
}

.badge-phone {
    background: rgba(20, 184, 166, 0.15);
    color: #2dd4bf;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
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
        <h4 class="mb-1">Data Dosen</h4>
        <p>Kelola informasi data profil dan administrasi dosen pada sistem akademik</p>
    </div>

    <div class="d-flex align-items-center" style="gap:8px;">
        <a href="{{ route('dosen.export-excel') }}" class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i> Export Excel
        </a>

        <a href="{{ route('dosen.print') }}" target="_blank" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>

        @if(Auth::user()->role == 'petugas' || Auth::user()->role == 'admin')
            <a href="{{ route('dosen.create') }}" class="btn btn-add">
                <i class="bi bi-plus-lg"></i> Tambah Dosen
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

{{-- SEARCH SYSTEM --}}
<form method="GET" class="mb-4 d-flex gap-2" style="max-width: 450px; width: 100%;">
    <input type="text" name="search"
        value="{{ request('search') }}"
        class="form-control search-box"
        placeholder="Cari NIDN / Nama / Email..."
        style="padding: 5px 12px; font-size: 0.9rem;">

    <button type="submit" class="btn btn-add text-nowrap d-inline-flex align-items-center justify-content-center gap-2"
        style="padding: 5px 16px !important; font-size: 0.9rem; border-radius: 10px;">
        <i class="bi bi-search"></i> 
        <span>Cari</span>
    </button>
</form>

{{-- TABLE CARD --}}
<div class="card-table">
    <div class="table-responsive">
        <table class="table-custom align-middle">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>NIDN</th>
                    <th>Nama Dosen</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    @if(Auth::user()->role == 'petugas' || Auth::user()->role == 'admin')
                    <th width="200" class="text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($dosens as $dosen)
                <tr>
                    <td class="text-light-muted small">{{ $dosens->firstItem() + $loop->index }}</td>
                    
                    <td>
                        <span class="badge-nidn text-nowrap">{{ $dosen->nidn }}</span>
                    </td>
                    
                    <td class="fw-semibold text-white">{{ $dosen->nama_dosen }}</td>
                    <td class="text-email small">{{ $dosen->email ?? '-' }}</td>
                    
                    <td>
                        @if($dosen->no_hp)
                            <span class="badge-phone text-nowrap">
                                <i class="bi bi-telephone me-1" style="font-size: 11px;"></i> {{ $dosen->no_hp }}
                            </span>
                        @else
                            <span class="text-secondary">-</span>
                        @endif
                    </td>
                    
                    <td class="text-light-muted small">
                        @if($dosen->alamat)
                            {{ Str::limit($dosen->alamat, 40) }}
                        @else
                            -
                        @endif
                    </td>
                    @if(Auth::user()->role == 'petugas' || Auth::user()->role == 'admin')
                    <td>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('dosen.edit', $dosen->id_dosen) }}" class="btn btn-action btn-edit">
                                <i class="bi bi-pencil"></i> Edit
                            </a>

                            <form action="{{ route('dosen.destroy', $dosen->id_dosen) }}" method="POST" class="delete-form d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-action btn-delete">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ Auth::user()->role == 'petugas' || Auth::user()->role == 'admin' ? 7 : 6 }}">
                        <div class="empty-state py-5">
                            <i class="bi bi-person-workspace fs-1 d-block mb-2 text-muted"></i>
                            <p class="mb-0">Tidak ada data dosen yang ditemukan</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    @if($dosens->hasPages())
    <div class="mt-4 d-flex justify-content-end">
        {{ $dosens->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

@endsection