@extends('layouts.app')

@section('content')

<style>
.dashboard-header h2 {
    font-weight: 700;
}

.dashboard-header p {
    color: #94a3b8;
}

/* CARD */
.stat-card {
    background: #1e293b;
    border-radius: 16px;
    padding: 20px;
    border: 1px solid #334155;
    position: relative;
    transition: 0.3s;
}

.stat-card:hover {
    transform: translateY(-4px);
    border-color: #3b82f6;
}

.stat-title {
    font-size: 0.8rem;
    color: #94a3b8;
}

.stat-value {
    font-size: 28px;
    font-weight: bold;
}

.stat-icon {
    position: absolute;
    right: 15px;
    bottom: 10px;
    font-size: 35px;
    opacity: 0.1;
}

/* CARD */
.info-card {
    background: #1e293b;
    border-radius: 16px;
    padding: 20px;
    border: 1px solid #334155;
}

/* TABLE */
.table-dark-custom {
    width: 100%;
    color: #e2e8f0;
}

.table-dark-custom th {
    font-size: 0.75rem;
    color: #94a3b8;
    text-transform: uppercase;
    border-bottom: 1px solid #334155;
}

.table-dark-custom td {
    border-top: 1px solid #334155;
}

.table-dark-custom tr:hover {
    background: #334155;
}

/* BADGE */
.badge-soft {
    background: rgba(59,130,246,0.15);
    color: #3b82f6;
    padding: 5px 10px;
    border-radius: 8px;
    font-size: 12px;
}
</style>

{{-- HEADER --}}
<div class="dashboard-header mb-4">
    <h2>Dashboard Akademik</h2>
    <p>Ringkasan data sistem akademik</p>
</div>

{{-- STAT --}}
<div class="row g-4 mb-4">

    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-title">Total Jurusan</div>
            <div class="stat-value text-primary">{{ \App\Models\Jurusan::count() }}</div>
            <div class="stat-icon"><i class="bi bi-building"></i></div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-title">Total Mahasiswa</div>
            <div class="stat-value text-success">{{ \App\Models\Mahasiswa::count() }}</div>
            <div class="stat-icon"><i class="bi bi-people"></i></div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-title">Total Matakuliah</div>
            <div class="stat-value text-warning">{{ \App\Models\Matakuliah::count() }}</div>
            <div class="stat-icon"><i class="bi bi-book"></i></div>
        </div>
    </div>

</div>

{{-- CHART --}}
<div class="row g-4 mb-4">
    <div class="col-md-12">
        <div class="info-card">
            <h5 class="fw-bold mb-3">Jumlah Mahasiswa per Jurusan</h5>
            <canvas id="chartMahasiswa"></canvas>
        </div>
    </div>
</div>

<div class="row g-4">

    {{-- MAHASISWA --}}
    <div class="col-md-6">
        <div class="info-card">
            <div class="d-flex justify-content-between mb-3">
                <h5 class="fw-bold">Mahasiswa Terbaru</h5>
                <span class="badge-soft">Update</span>
            </div>

            <table class="table-dark-custom">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jurusan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(\App\Models\Mahasiswa::with('jurusan')->latest()->take(5)->get() as $m)
                    <tr>
                        <td>{{ $m->nama }}</td>
                        <td>{{ $m->jurusan->nama_jurusan }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- MATAKULIAH --}}
    <div class="col-md-6">
        <div class="info-card">
            <div class="d-flex justify-content-between mb-3">
                <h5 class="fw-bold">Matakuliah Terbaru</h5>
                <span class="badge-soft">Update</span>
            </div>

            <table class="table-dark-custom">
                <thead>
                    <tr>
                        <th>Matakuliah</th>
                        <th>SKS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(\App\Models\Matakuliah::latest()->take(5)->get() as $mk)
                    <tr>
                        <td>{{ $mk->nama_matakuliah }}</td>
                        <td>{{ $mk->sks }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- SCRIPT --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let labels = [
    @foreach(\App\Models\Jurusan::all() as $j)
        "{{ $j->nama_jurusan }}",
    @endforeach
];

let data = [
    @foreach(\App\Models\Jurusan::all() as $j)
        {{ \App\Models\Mahasiswa::where('id_jurusan', $j->id_jurusan)->count() }},
    @endforeach
];

let combined = labels.map((label, i) => ({
    label: label,
    value: data[i]
}));

combined.sort((a, b) => b.value - a.value);

labels = combined.map(item => item.label);
data = combined.map(item => item.value);

let colors = data.map((val, i) => i === 0 ? '#22c55e' : '#3b82f6');

new Chart(document.getElementById('chartMahasiswa'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            data: data,
            backgroundColor: colors,
            borderRadius: 8
        }]
    },
    options: {
        indexAxis: 'y',
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: {
                ticks: { color: '#94a3b8' },
                grid: { color: '#1e293b' }
            },
            y: {
                ticks: { color: '#e2e8f0' },
                grid: { display: false }
            }
        }
    }
});
</script>

@endsection