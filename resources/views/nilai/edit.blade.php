@extends('layouts.app')

@section('content')

<style>
body {
    background: #0f172a;
    font-family: 'Inter', sans-serif;
}

/* HEADER STYLE */
.page-header h4 {
    font-weight: 700;
    color: #fff;
}

.page-header p {
    color: #94a3b8;
    font-size: 0.85rem;
}

/* CONTAINER CARD DARK */
.card-form {
    background: #1e293b;
    border-radius: 16px;
    border: 1px solid #334155;
    padding: 24px;
}

/* FORM ELEMENTS SYSTEM */
.form-label {
    color: #94a3b8;
    font-size: 0.85rem;
    font-weight: 500;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.form-control, .form-select {
    background: #020617;
    border: 1px solid #334155;
    color: white;
    border-radius: 10px;
    padding: 10px 14px;
}

.form-control:focus, .form-select:focus {
    background: #020617;
    color: white;
    border-color: #3b82f6;
    box-shadow: none;
}

.form-select option {
    background: #1e293b;
    color: white;
}

/* VALIDATION INVALID STATE */
.form-control.is-invalid, .form-select.is-invalid {
    border-color: #ef4444;
    background-image: none;
}

.form-control.is-invalid:focus, .form-select.is-invalid:focus {
    border-color: #ef4444;
    box-shadow: none;
}

.invalid-feedback {
    color: #f87171;
    font-size: 0.80rem;
    margin-top: 6px;
}

/* BUTTONS SYSTEM */
.btn-save {
    background: #3b82f6;
    border: none;
    border-radius: 10px;
    padding: 10px 20px;
    color: white;
    font-weight: 500;
    transition: 0.2s;
}

.btn-save:hover {
    background: #2563eb;
    color: white;
}

.btn-cancel {
    background: transparent;
    border: 1px solid #475569;
    border-radius: 10px;
    padding: 10px 20px;
    color: #94a3b8;
    font-weight: 500;
    transition: 0.2s;
}

.btn-cancel:hover {
    background: #334155;
    color: white;
    border-color: #475569;
}
</style>

{{-- HEADER --}}
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="page-header mb-4">
            <h4 class="mb-1"><i class="bi bi-pencil-square me-2 text-primary"></i>Edit Nilai Akademik</h4>
            <p class="mb-0">Ubah perolehan akumulasi nilai angka mahasiswa berdasarkan evaluasi mata kuliah terkini</p>
        </div>
    </div>
</div>

{{-- ROW WRAPPER DENGAN JUSTIFY-CONTENT-CENTER --}}
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-form">

            <form action="{{ route('nilai.update', $nilai->id_nilai) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- DATA KRS / MAHASISWA --}}
                <div class="mb-3">
                    <label class="form-label text-uppercase">KRS / Mahasiswa Pemilik</label>
                    <select name="id_krs" class="form-select @error('id_krs') is-invalid @enderror">
                        <option value="">-- Pilih KRS Mahasiswa --</option>
                        @foreach($krs as $k)
                            <option value="{{ $k->id_krs }}" 
                                {{ old('id_krs', $nilai->id_krs) == $k->id_krs ? 'selected' : '' }}>
                                {{ $k->mahasiswa->nim ?? '-' }} - {{ $k->mahasiswa->nama ?? 'Tidak Diketahui' }} (Semester {{ $k->semester }})
                            </option>
                        @endforeach
                    </select>
                    
                    @error('id_krs')
                    <div class="invalid-feedback">
                        <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                    </div>
                    @enderror
                </div>

                {{-- MATA KULIAH --}}
                <div class="mb-3">
                    <label class="form-label text-uppercase">Mata Kuliah</label>
                    <select name="id_matakuliah" class="form-select @error('id_matakuliah') is-invalid @enderror">
                        <option value="">-- Pilih Mata Kuliah --</option>
                        @foreach($matakuliahs as $mk)
                            <option value="{{ $mk->id_matakuliah }}"
                                {{ old('id_matakuliah', $nilai->id_matakuliah) == $mk->id_matakuliah ? 'selected' : '' }}>
                                {{ $mk->kode_matakuliah }} - {{ $mk->nama_matakuliah }}
                            </option>
                        @endforeach
                    </select>

                    @error('id_matakuliah')
                    <div class="invalid-feedback">
                        <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                    </div>
                    @enderror
                </div>

                {{-- NILAI ANGKA --}}
                <div class="mb-4">
                    <label class="form-label text-uppercase">Skor Nilai Angka</label>
                    <input type="number" 
                           step="0.01" 
                           min="0" 
                           max="100" 
                           name="nilai_angka" 
                           value="{{ old('nilai_angka', $nilai->nilai_angka) }}" 
                           class="form-control @error('nilai_angka') is-invalid @enderror"
                           placeholder="Masukkan rentang angka 0 - 100...">

                    @error('nilai_angka')
                    <div class="invalid-feedback">
                        <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                    </div>
                    @enderror
                </div>

                {{-- ACTIONS BUTTONS --}}
                <div class="d-flex justify-content-end gap-2 border-top border-secondary pt-3">
                    <a href="{{ route('nilai.index') }}" class="btn btn-cancel">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-save">
                        <i class="bi bi-arrow-clockwise me-2"></i> Perbarui Nilai
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection