@extends('layouts.app')

@section('content')

<style>
body {
    background: #0f172a;
    font-family: 'Inter', sans-serif;
}

.dashboard-header h2 {
    font-weight: 700;
    color: #fff;
}

.dashboard-header p {
    color: #94a3b8;
}

/* CARD STATISTIK */
.stat-card {
    background: #1e293b;
    border: 1px solid #334155;
    border-radius: 18px;
    padding: 22px;
    position: relative;
    overflow: hidden;
    transition: .3s;
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-5px);
    border-color: #3b82f6;
    box-shadow: 0 15px 35px rgba(0,0,0,.25);
}

.stat-title {
    color: #94a3b8;
    font-size: .8rem;
    text-transform: uppercase;
    margin-bottom: 10px;
}

.stat-value {
    font-size: 34px;
    font-weight: bold;
}

.stat-icon {
    position: absolute;
    right: 18px;
    bottom: 10px;
    font-size: 42px;
    opacity: .08;
}

/* CARD CONTAINER INFO */
.info-card {
    background: #1e293b;
    border: 1px solid #334155;
    border-radius: 18px;
    padding: 22px;
    height: 100%;
}

.badge-soft {
    background: rgba(59, 130, 246, 0.15);
    color: #60a5fa;
    padding: 6px 12px;
    border-radius: 10px;
    font-size: 0.8rem;
}

/* TIMELINE AKTIVITAS */
.timeline-container {
    position: relative;
    padding-left: 24px;
}

.timeline-container::before {
    content: '';
    position: absolute;
    left: 6px;
    top: 5px;
    width: 2px;
    height: 90%;
    background: #334155;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-dot {
    position: absolute;
    left: -23px;
    top: 4px;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    border: 3px solid #1e293b;
}

canvas {
    max-height: 260px;
}
</style>

<div class="dashboard-header mb-4">
    <h2>Dashboard Analitik Akademik</h2>
    <p>Ringkasan indikator data penting dan manajemen hak akses aktivitas saat ini.</p>
</div>

{{-- 1. KAUNTER RINGKASAN UTAMA --}}
<div class="row g-4 mb-4">
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="stat-card">
            <div class="stat-title">Jurusan</div>
            <div class="stat-value text-primary">{{ $jumlahJurusan }}</div>
            <div class="stat-icon"><i class="bi bi-building"></i></div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="stat-card">
            <div class="stat-title">Mahasiswa</div>
            <div class="stat-value text-success">{{ $jumlahMahasiswa }}</div>
            <div class="stat-icon"><i class="bi bi-people"></i></div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="stat-card">
            <div class="stat-title">Dosen</div>
            <div class="stat-value text-info">{{ $jumlahDosen }}</div>
            <div class="stat-icon"><i class="bi bi-person-badge"></i></div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="stat-card">
            <div class="stat-title">Mata Kuliah</div>
            <div class="stat-value text-warning">{{ $jumlahMatakuliah }}</div>
            <div class="stat-icon"><i class="bi bi-book"></i></div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="stat-card">
            <div class="stat-title">Total KRS</div>
            <div class="stat-value text-danger">{{ $jumlahKrs }}</div>
            <div class="stat-icon"><i class="bi bi-journal-check"></i></div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="stat-card">
            <div class="stat-title">Log Nilai</div>
            <div class="stat-value text-light">{{ $jumlahNilai }}</div>
            <div class="stat-icon"><i class="bi bi-award"></i></div>
        </div>
    </div>
</div>

{{-- 2. ROW GRAFIK AKADEMIK --}}
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="info-card">
            <h5 class="fw-bold mb-3 text-white"><i class="bi bi-bar-chart-line text-primary me-2"></i>Distribusi Registrasi KRS Per Semester</h5>
            <canvas id="krsSemesterBarChart"></canvas>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="info-card">
            <h5 class="fw-bold mb-3 text-white"><i class="bi bi-pie-chart text-danger me-2"></i>Rasio Kelulusan Nilai</h5>
            <div style="max-width: 220px; margin: 0 auto;">
                <canvas id="rasioKelulusanChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-4">
        <div class="info-card">
            <h5 class="fw-bold mb-3 text-white"><i class="bi bi-pie-chart-fill text-info me-2"></i>Proporsi Mahasiswa / Jurusan</h5>
            <div style="max-width: 220px; margin: 0 auto;">
                <canvas id="jurusanPieChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="info-card">
            <h5 class="fw-bold mb-3 text-white"><i class="bi bi-calendar3 text-warning me-2"></i>Pertumbuhan Mahasiswa Per Angkatan</h5>
            <canvas id="angkatanBarChart"></canvas>
        </div>
    </div>
</div>

{{-- 3. ROW LOG MONITORING & LIVE DATA (KONDISIONAL ROLE) --}}
<div class="row g-4">
    {{-- Tabel Mahasiswa Baru (Bisa dilihat oleh Admin & Petugas) --}}
    <div class="col-lg-7">
        <div class="info-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0 text-white">Mahasiswa Terbaru Terdaftar</h5>
                <span class="badge-soft">5 Input Terakhir</span>
            </div>
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Jurusan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mahasiswaTerbaru as $m)
                            <tr>
                                <td class="text-info font-monospace">{{ $m->nim }}</td>
                                <td class="fw-semibold">{{ $m->nama }}</td>
                                <td>{{ $m->jurusan->nama_jurusan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada data mahasiswa</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- SINKRONISASI KONDISIONAL BERDASARKAN ROLE USER --}}
    <div class="col-lg-5">
        @if(Auth::user()->role === 'admin')
            {{-- TAMPILAN KHUSUS ADMIN: Menampilkan Data Tabel ActivityLog Asli --}}
            <div class="info-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0 text-white"><i class="bi bi-clock-history text-primary me-2"></i>Aktivitas Sistem Terbaru</h5>
                    <span class="badge bg-primary text-dark fw-bold px-2 py-1 small">Live Log</span>
                </div>
                <div class="timeline-container">
                    @forelse($recentLogs as $log)
                        <div class="timeline-item">
                            @php
                                // Penentuan warna dot berdasarkan jenis operasi database
                                $dotColor = 'bg-secondary';
                                if($log->aksi === 'CREATE') $dotColor = 'bg-success';
                                if($log->aksi === 'UPDATE') $dotColor = 'bg-warning';
                                if($log->aksi === 'DELETE') $dotColor = 'bg-danger';
                            @endphp
                            <div class="timeline-dot {{ $dotColor }}"></div>
                            <small class="text-muted d-block">{{ $log->created_at?->diffForHumans() ?? 'Baru saja' }}</small>
                            <span class="text-white small">
                                <strong class="text-info">{{ $log->user->name ?? 'System' }}</strong>: 
                                {{ $log->aktivitas }} pada modul <code class="text-warning">{{ $log->modul }}</code>.
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted small">
                            <i class="bi bi-hourglass-split d-block fs-3 mb-2"></i> Belum ada rekaman aktivitas sistem.
                        </div>
                    @endforelse
                </div>
            </div>
        @else
            {{-- TAMPILAN KHUSUS PETUGAS: Menampilkan Data Dosen Terbaru --}}
            <div class="info-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-white"><i class="bi bi-person-badge text-info me-2"></i>Dosen Baru Terdaftar</h5>
                    <span class="badge-soft" style="background: rgba(13, 202, 240, 0.15); color: #0dcaf0;">Staf Pengajar</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>NIDN</th>
                                <th>Nama Dosen</th>
                                <th>No. HP</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Mengambil 4-5 data dari variabel koleksi $jumlahDosen / data dosen yang di-passing --}}
                            @forelse(\App\Models\Dosen::latest()->take(5)->get() as $d)
                                <tr>
                                    <td class="text-info font-monospace" style="font-size: 0.85rem;">{{ $d->nidn }}</td>
                                    <td class="fw-semibold" style="font-size: 0.85rem;">{{ $d->nama_dosen }}</td>
                                    <td class="text-white-50 font-monospace" style="font-size: 0.8rem;">{{ $d->no_hp ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted small py-3">Belum ada data dosen terdaftar</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- 4. JAVASCRIPT CHART.JS ENGINE --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// --- Chart 1: KRS per Semester ---
const ctxKrs = document.getElementById('krsSemesterBarChart');
if(ctxKrs) {
    new Chart(ctxKrs, {
        type: 'bar',
        data: {
            labels: [@foreach($krsPerSemester as $k) 'Semester {{ $k->semester }}', @endforeach],
            datasets: [{
                label: 'Jumlah Pengisian KRS',
                data: [@foreach($krsPerSemester as $k) {{ $k->total }}, @endforeach],
                backgroundColor: '#3b82f6',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { grid: { color: '#334155' }, ticks: { color: '#94a3b8' } },
                x: { grid: { display: false }, ticks: { color: '#94a3b8' } }
            },
            plugins: { legend: { display: false } }
        }
    });
}

// --- Chart 2: HIGHLIGHT RASIO KELULUSAN ---
const ctxRasio = document.getElementById('rasioKelulusanChart');
if(ctxRasio) {
    new Chart(ctxRasio, {
        type: 'doughnut',
        data: {
            labels: ['Lulus (A/B/C)', 'Tidak Lulus (D)'],
            datasets: [{
                data: [{{ $rasioKelulusan['Lulus'] }}, {{ $rasioKelulusan['Tidak_Lulus'] }}],
                backgroundColor: ['#10b981', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { color: '#94a3b8', boxWidth: 12 } }
            }
        }
    });
}

// --- Chart 3: Pie Proporsi Jurusan ---
const ctxPie = document.getElementById('jurusanPieChart');
if(ctxPie) {
    new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: [@foreach($jurusanChart as $j) '{{ $j->nama_jurusan }}', @endforeach],
            datasets: [{
                data: [@foreach($jurusanChart as $j) {{ $j->mahasiswas_count }}, @endforeach],
                backgroundColor: ['#06b6d4', '#a855f7', '#f59e0b', '#ec4899', '#3b82f6', '#10b981'],
                borderWidth: 1,
                borderColor: '#1e293b'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { color: '#94a3b8', boxWidth: 10 } }
            }
        }
    });
}

// --- Chart 4: Bar Chart Mahasiswa per Angkatan ---
const ctxBarAngkat = document.getElementById('angkatanBarChart');
if(ctxBarAngkat) {
    new Chart(ctxBarAngkat, {
        type: 'bar',
        data: {
            labels: [@foreach($angkatanChart as $a) 'Angkatan {{ $a->tahun ?? "N/A" }}', @endforeach],
            datasets: [{
                label: 'Mahasiswa Terdaftar',
                data: [@foreach($angkatanChart as $a) {{ $a->total }}, @endforeach],
                backgroundColor: '#f59e0b',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { grid: { color: '#334155' }, ticks: { color: '#94a3b8' } },
                x: { grid: { display: false }, ticks: { color: '#94a3b8' } }
            },
            plugins: { legend: { display: false } }
        }
    });
}
</script>

@endsection