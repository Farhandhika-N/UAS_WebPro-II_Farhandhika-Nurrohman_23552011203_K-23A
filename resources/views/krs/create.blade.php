@extends('layouts.app')

@section('content')
<style>
    .card-form {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 16px;
        padding: 30px;
        color: #e2e8f0;
    }
    .form-control-custom {
        background: #020617;
        border: 1px solid #334155;
        color: white;
    }
    .form-control-custom:focus {
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

    .text-muted {
        color: #94a3b8 !important;
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
    background: #3b82f6;
    border: none;
    border-radius: 10px;
    padding: 10px 18px;
}

.btn-save:hover {
    background: #2563eb;
}

.btn-cancel {
    background: transparent;
    border: 1px solid #334155;
    color: #94a3b8;
    border-radius: 10px;
    padding: 10px 18px;
}

.btn-cancel:hover {
    background: #1e293b;
    color: white;
}
</style>

<div class="form-header mb-3">
    <h4>Tambah Kartu Rencana Studi (KRS)</h4>
    <p class="text-muted">Input data pengambilan semester mahasiswa</p>
</div>

<div class="card-form">
    <form action="{{ route('krs.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Pilih Mahasiswa</label>
            <select name="id_mahasiswa" class="form-select form-control-custom" required>
                <option value="">-- Pilih Mahasiswa --</option>
                @foreach($mahasiswas as $mhs)
                    <option value="{{ $mhs->id_mahasiswa }}">{{ $mhs->nim }} - {{ $mhs->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Semester</label>
            <input type="number" name="semester" class="form-control form-control-custom" placeholder="Contoh: 6" min="1" max="14" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tahun Ajaran</label>
            <input type="text" name="tahun_ajaran" class="form-control form-control-custom" placeholder="Contoh: 2025/2026" required>
        </div>

        <hr class="my-4" style="border-color: #334155;">

            <h5 class="mb-3">Pilih Mata Kuliah</h5>
            
            @php
                $selected = [];
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

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-save">
                    <i class="bi bi-check-lg"></i> Simpan
                </button>

                <a href="{{ route('krs.index') }}" class="btn btn-cancel">
                    Batal
                </a>
            </div>
    </form>
</div>

<script>
    function hitungSKS(event) {
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
