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

/* CARD CONTAINER */
.card-table {
    background: #1e293b;
    border-radius: 16px;
    border: 1px solid #334155;
    padding: 24px;
}

/* TABLE CUSTOM */
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
    white-space: nowrap;
}

.table-custom td {
    padding: 14px 12px;
    border-top: 1px solid #334155;
}

.table-custom tbody tr:hover {
    background: #243146;
}

/* SEARCH BOX */
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

.btn-search {
    background: #3b82f6;
    border: none;
    border-radius: 10px;
    color: white;
    padding: 8px 16px;
}

.btn-search:hover {
    background: #2563eb;
    color: white;
}

/* PAGINATION OVERRIDE */
.page-link {
    background: #1e293b;
    color: white;
    border-color: #334155;
}

.page-link:hover {
    background: #3b82f6;
    color: white;
}
</style>

{{-- HEADER --}}
<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="mb-1">
            <i class="bi bi-clock-history me-2 text-primary"></i>Activity Log
        </h4>
        <p class="text-white-50 small mb-0">Riwayat jejak aktivitas seluruh pengguna pada sistem akademik</p>
    </div>
</div>

{{-- CARD WRAPPER --}}
<div class="card-table">

    {{-- SEARCH SYSTEM --}}
    <form method="GET" class="mb-4">
        <div class="row g-2" style="max-width: 600px;">
            <div class="col-md-8">
                <input type="text" name="search"
                    value="{{ request('search') }}"
                    class="form-control search-box h-100"
                    placeholder="Cari user / modul / aktivitas...">
            </div>
            <div class="col-md-4">
                <button class="btn btn-search w-100 h-100">
                    <i class="bi bi-search me-1"></i> Cari
                </button>
            </div>
        </div>
    </form>

    {{-- TABLE RESPONSIVE --}}
    <div class="table-responsive">
        <table class="table-custom align-middle">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>User</th>
                    <th>Modul</th>
                    <th>Aksi</th>
                    <th>Aktivitas</th>
                    <th>IP Address</th>
                    <th>Browser</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td class="text-white-50 small">
                        {{ $loop->iteration + ($logs->currentPage()-1) * $logs->perPage() }}
                    </td>
                    <td>
                        <strong class="text-white d-block mb-0">{{ $log->user->name }}</strong>
                        <span class="badge bg-dark border border-secondary text-white-50 font-monospace" style="font-size: 10px;">
                            {{ strtoupper($log->user->role) }}
                        </span>
                    </td>
                    <td>
                        <span class="text-info fw-semibold font-monospace small">{{ $log->modul }}</span>
                    </td>
                    <td>
                        @php
                            $badgeColor = match($log->aksi) {
                                'CREATE' => 'rgba(16, 185, 129, 0.15); color: #10b981;',
                                'UPDATE' => 'rgba(59, 130, 246, 0.15); color: #3b82f6;',
                                'DELETE' => 'rgba(239, 68, 68, 0.15); color: #ef4444;',
                                'LOGIN'  => 'rgba(6, 182, 212, 0.15); color: #06b6d4;',
                                'LOGOUT' => 'rgba(148, 163, 184, 0.15); color: #94a3b8;',
                                default  => 'rgba(148, 163, 184, 0.15); color: #94a3b8;'
                            };
                        @endphp
                        <span class="fw-bold px-2 py-1 rounded font-monospace small" style="background: {{ $badgeColor }}">
                            {{ $log->aksi }}
                        </span>
                    </td>
                    <td class="text-white-50 small" style="max-width: 250px; white-space: normal;">
                        {{ $log->aktivitas }}
                    </td>
                    <td class="text-warning font-monospace small">
                        {{ $log->ip_address }}
                    </td>
                    <td style="max-width: 200px; white-space: normal;">
                        <small class="text-white-50 text-wrap font-monospace d-block" style="font-size: 11px; line-height: 1.3;">
                            {{ Str::limit($log->user_agent, 60) }}
                        </small>
                    </td>
                    <td>
                        <span class="text-white font-monospace small d-block mb-0">{{ $log->created_at->format('d M Y') }}</span>
                        <small class="text-white-50 font-monospace" style="font-size: 11px;">{{ $log->created_at->format('H:i:s') }} WIB</small>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-white-50 py-5">
                        <i class="bi bi-clock-history fs-2 d-block mb-2 text-muted"></i>
                        Belum ada riwayat aktivitas yang tercatat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    @if($logs->hasPages())
    <div class="mt-4 d-flex justify-content-end">
        {{ $logs->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

@endsection