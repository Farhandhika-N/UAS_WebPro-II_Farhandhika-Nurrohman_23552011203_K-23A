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

/* CARD CONTAINER */
.card-table {
    background: #1e293b;
    border-radius: 16px;
    border: 1px solid #334155;
    padding: 24px;
}

/* TABLE CUSTOM STYLES */
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

/* TEXT COLOR REGULATION */
.text-light-muted {
    color: #ffffff !important;
}

.text-email {
    color: #94a3b8 !important;
}

/* SEARCH SYSTEM */
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
    font-weight: 500;
    font-size: 0.9rem;
    height: 48px;
    white-space: nowrap;
    transition: 0.2s;
}

.btn-search:hover {
    background: #2563eb;
    color: white;
}

/* MAIN ACCESS BUTTONS */
.btn-add {
    background: #3b82f6;
    border: none;
    border-radius: 10px;
    padding: 8px 16px;
    color: white;
    display: inline-flex;
    align-items: center;
}

.btn-add:hover {
    background: #2563eb;
    color: white;
}

/* ACTION GRID BUTTONS */
.btn-action {
    border-radius: 8px;
    padding: 6px 12px;
    font-size: 13px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    transition: 0.2s;
    border: none;
}

.btn-edit {
    background: #3b82f6;
    color: white;
}

.btn-edit:hover {
    background: #2563eb;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    color: white;
}

.btn-password {
    background: #0ea5e9;
    color: white;
}

.btn-password:hover {
    background: #0284c7;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(14, 165, 233, 0.4);
    color: white;
}

.btn-delete {
    background: #ef4444;
    color: white;
}

.btn-delete:hover {
    background: #dc2626;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
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
        <h4 class="mb-1">
            <i class="bi bi-person-gear me-2"></i>Manajemen User
        </h4>
        <p>Kelola akun pengguna sistem, tingkat otoritas (role), serta konfigurasi keamanan</p>
    </div>

    <div class="d-flex align-items-center" style="gap:8px;">
        <a href="{{ route('user.create') }}" class="btn btn-add">
            <i class="bi bi-plus-lg"></i> Tambah User
        </a>
    </div>
</div>

{{-- SYSTEM NOTIFICATION ALERTS --}}
@if(session('success'))
    <div class="alert alert-success border-0 mb-4" style="border-radius: 12px; background-color: rgba(16, 185, 129, 0.2) !important; color: #34d399 !important;">
        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger border-0 mb-4" style="border-radius: 12px; background-color: rgba(239, 68, 68, 0.2) !important; color: #f87171 !important;">
        <i class="bi bi-exclamation-circle me-2"></i> {{ session('error') }}
    </div>
@endif

{{-- FORM PENCARIAN --}}
<form method="GET" class="mb-4">
    <div class="d-flex gap-2 search-wrapper">
        <div class="flex-grow-1">
            <input type="text" 
                   name="search" 
                   class="form-control search-box" 
                   placeholder="Cari nama / email / role..." 
                   value="{{ request('search') }}">
        </div>
        
        <button type="submit" class="btn btn-search d-flex align-items-center justify-content-center gap-2">
            <i class="bi bi-search"></i> Cari
        </button>
    </div>
</form>

{{-- MAIN CONTENT CARD TABLE --}}
<div class="card-table">
    <div class="table-responsive">
        <table class="table-custom align-middle">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Dibuat</th>
                    <th width="240" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="text-light-muted small">
                        {{ $loop->iteration + ($users->firstItem() - 1) }}
                    </td>
                    
                    <td class="fw-semibold text-white">
                        {{ $user->name }}
                        @if($user->id == auth()->id())
                            <span class="badge ms-2" style="background: rgba(6, 182, 212, 0.15); color: #22d3ee;">
                                Anda
                            </span>
                        @endif
                    </td>
                    
                    <td class="text-email small">{{ $user->email }}</td>
                    
                    <td>
                        @if($user->role == 'admin')
                            <span class="badge" style="background: rgba(239, 68, 68, 0.15); color: #f87171; font-size: 0.75rem;">
                                ADMIN
                            </span>
                        @else
                            <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #34d399; font-size: 0.75rem;">
                                PETUGAS
                            </span>
                        @endif
                    </td>
                    
                    <td class="text-light-muted small">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    
                    <td>
                        <div class="d-flex gap-2 justify-content-center">
                            {{-- Button Edit --}}
                            <a href="{{ route('user.edit', $user) }}" class="btn btn-action btn-edit" title="Edit User">
                                <i class="bi bi-pencil-square me-1"></i> Edit
                            </a>

                            {{-- Button Ganti Password --}}
                            <a href="{{ route('user.password.edit', $user) }}" class="btn btn-action btn-password" title="Ganti Password">
                                <i class="bi bi-key me-1"></i> Sandi
                            </a>

                            {{-- Button Hapus --}}
                            @if($user->id != auth()->id())
                            <form action="{{ route('user.destroy', $user) }}" method="POST" class="delete-form d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-action btn-delete">
                                    <i class="bi bi-trash me-1"></i> Hapus
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state py-5">
                            <i class="bi bi-people fs-1 d-block mb-2 text-muted"></i>
                            <p class="mb-0">Tidak ada data akun user yang ditemukan</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION LINKS --}}
    @if($users->hasPages())
    <div class="mt-4 d-flex justify-content-end">
        {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

@endsection