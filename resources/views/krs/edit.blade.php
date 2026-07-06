@extends('layouts.app')

@section('content')
<style>
    .form-card {
        background: #1e293b;
        border-radius: 16px;
        border: 1px solid #334155;
        padding: 25px;
    }

    .form-header h4 {
        font-weight: 600;
    }

    .form-header p {
        color: #94a3b8;
        font-size: .85rem;
    }

    .form-control,
    .form-select {
        background: #020617;
        border: 1px solid #334155;
        color: white;
    }

    .form-control:focus,
    .form-select:focus {
        background: #020617;
        color: white;
        border-color: #3b82f6;
        box-shadow: none;
    }

    .card-mk {
        background: #0f172a;
        border: 1px solid #334155;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 10px;
        display: block;
        cursor: pointer;
    }

    .card-mk:hover {
        border-color: #3b82f6;
    }

    .total-box {
        background: #2563eb;
        color: white;
        padding: 15px;
        border-radius: 12px;
        text-align: center;
    }

    .btn-save {
        background: #2563eb;
        color: white;
    }

    .btn-cancel {
        background: #64748b;
        color: white;
    }
</style>

<div class="col-lg-8 mx-auto py-4">
    <div class="form-header mb-4">
        <h4 class="mb-1"><i class="bi bi-pencil-square me-2 text-primary"></i>Edit KRS</h4>
        <p>Perbarui data Kartu Rencana Studi mahasiswa.</p>
    </div>

    <div class="form-card">
        <form action="{{ route('krs.update', $krs->id_krs) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Mahasiswa</label>
                <select name="id_mahasiswa" class="form-select">
                    @foreach($mahasiswas as $m)
                        <option value="{{ $m->id_mahasiswa }}" {{ old('id_mahasiswa', $krs->id_mahasiswa) == $m->id_mahasiswa ? 'selected' : '' }}>
                            {{ $m->nim }} - {{ $m->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Semester</label>
                    <select name="semester" class="form-select">
                        @for($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}" {{ old('semester', $krs->semester) == $i ? 'selected' : '' }}>
                                Semester {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tahun Ajaran</label>
                    <input type="text" name="tahun_ajaran" class="form-control" value="{{ old('tahun_ajaran', $krs->tahun_ajaran) }}">
                </div>
            </div>

            <hr class="my-4" style="border-color: #334155;">

            <h5 class="mb-3">Pilih Mata Kuliah</h5>
            
            @php
                $selected = $krs->nilais ? $krs->nilais->pluck('id_matakuliah')->toArray() : [];
            @endphp

            <div class="row">
                @foreach($matakuliahs as $mk)
                    <div class="col-md-6">
                        <label class="card-mk w-100">
                            <div class="form-check">
                                <input type="checkbox" 
                                       class="form-check-input mk-check" 
                                       name="matakuliah[]" 
                                       value="{{ $mk->id_matakuliah }}" 
                                       data-sks="{{ $mk->sks }}"
                                       {{ in_array($mk->id_matakuliah, $selected) ? 'checked' : '' }}>
                                
                                <div class="form-check-label ms-1">
                                    <div class="fw-bold text-white">{{ $mk->nama_matakuliah }}</div>
                                    <small class="text-muted d-block">Kode: {{ $mk->kode_matakuliah }}</small>
                                    <small class="text-secondary d-block">{{ $mk->jurusan->nama_jurusan ?? '-' }}</small>
                                    <span class="badge bg-primary mt-2">{{ $mk->sks }} SKS</span>
                                </div>
                            </div>
                        </label>
                    </div>
                @endforeach
            </div>

            <div class="my-4">
                <div class="total-box">
                    <span class="text-uppercase tracking-wider small opacity-75">Total SKS Terpilih</span>
                    <h2 id="totalSKS" class="mb-0 fw-bold mt-1">0</h2>
                </div>
            </div>

        <div class="d-flex justify-content-end gap-2 border-top border-secondary pt-3">
            <a href="{{ route('krs.index') }}" class="btn btn-cancel d-flex align-items-center">
                Batal
            </a>
            <button type="submit" class="btn btn-save d-flex align-items-center">
                <i class="bi bi-arrow-clockwise me-2"></i> Perbarui Data
            </button>
        </div>
        </form>
    </div>
</div>

<script>
    function hitungSKS() {
       let total = 0;
        const MAKS_SKS = 24; // Atur batas maksimal SKS di sini

        document.querySelectorAll('.mk-check:checked').forEach(function(item) {
            total += parseInt(item.dataset.sks) || 0;
        });

        // Validasi: Jika melebihi batas maksimal SKS
        if (total > MAKS_SKS) {
            alert('Batas maksimal pengambilan adalah ' + MAKS_SKS + ' SKS. Anda tidak dapat menambah mata kuliah ini.');
            
            // Jika dipicu oleh event 'change' (user yang mengklik)
            if (event && event.target) {
                event.target.checked = false; // Batalkan centangan terakhir
            }
            
            // Hitung ulang total SKS setelah centangan dibatalkan
            total = 0;
            document.querySelectorAll('.mk-check:checked').forEach(function(item) {
                total += parseInt(item.dataset.sks) || 0;
            });
        }

        // Tampilkan hasil ke komponen HTML
        document.getElementById('totalSKS').innerHTML = total;
        const totalBox = document.querySelector('.total-box');
        if (totalBox) {
            if (total === MAKS_SKS) {
                totalBox.style.background = '#10b981'; // Hijau jika pas 24 SKS
            } else {
                totalBox.style.background = '#2563eb'; // Tetap biru jika di bawah 24 SKS
            }
        }
    }

    document.querySelectorAll('.mk-check').forEach(function(item) {
        // Teruskan 'event' ke fungsi hitungSKS agar tahu checkbox mana yang terakhir diklik
        item.addEventListener('change', function(e) {
            hitungSKS(e);
        });
    });

    // Jalankan hitung pertama kali saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        hitungSKS();
    });
</script>
@endsection