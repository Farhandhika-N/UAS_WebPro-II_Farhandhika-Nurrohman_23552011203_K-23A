@extends('layouts.app')

@section('content')

<style>
.form-card{
    background:#1e293b;
    border:1px solid #334155;
    border-radius:16px;
    padding:25px;
}

.form-header h4{
    font-weight:600;
}

.form-header p{
    color:#94a3b8;
    font-size:.9rem;
}

.form-control,
.form-select{
    background:#020617;
    border:1px solid #334155;
    color:#e2e8f0;
    border-radius:10px;
}

.form-control:focus,
.form-select:focus{
    background:#020617;
    color:white;
    border-color:#3b82f6;
    box-shadow:none;
}

.form-control::placeholder{
    color:#64748b;
}

.btn-save{
    background:#3b82f6;
    border:none;
    border-radius:10px;
}

.btn-save:hover{
    background:#2563eb;
}

.btn-cancel{
    border:1px solid #334155;
    border-radius:10px;
    color:#94a3b8;
}

.btn-cancel:hover{
    background:#334155;
    color:white;
}

.grade-box{
    font-size:30px;
    font-weight:bold;
    text-align:center;
    border-radius:12px;
    padding:15px;
    background:#0f172a;
    border:1px solid #334155;
    color:#22c55e;
}
</style>

<div class="col-lg-7 mx-auto">

    <div class="form-header mb-4">
        <h4>Tambah Nilai</h4>
        <p>Masukkan data nilai mahasiswa berdasarkan KRS.</p>
    </div>

    <div class="form-card">

        <form action="{{ route('nilai.store') }}" method="POST">

            @csrf

            {{-- Pilihan Mahasiswa Menggunakan ID KRS --}}
            <div class="mb-3">

                <label class="form-label text-secondary small">
                    Mahasiswa (KRS)
                </label>

                <select name="id_krs"
                        class="form-select @error('id_krs') is-invalid @enderror">

                    <option value="">-- Pilih Mahasiswa --</option>

                    @foreach($krs_list as $krs)

                    <option
                        value="{{ $krs->id_krs }}"
                        {{ old('id_krs') == $krs->id_krs ? 'selected' : '' }}>

                        {{-- Menampilkan NIM dan Nama Mahasiswa yang terelasi di data KRS --}}
                        {{ $krs->mahasiswa->nim ?? '' }} - {{ $krs->mahasiswa->nama ?? 'Data Tidak Ditemukan' }} (Semester {{ $krs->semester ?? '' }})

                    </option>

                    @endforeach

                </select>

                @error('id_krs')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>

            {{-- Mata Kuliah --}}
            <div class="mb-3">

                <label class="form-label text-secondary small">
                    Mata Kuliah
                </label>

                <select name="id_matakuliah"
                        class="form-select @error('id_matakuliah') is-invalid @enderror">

                    <option value="">-- Pilih Mata Kuliah --</option>

                    @foreach($matakuliahs as $mk)

                    <option
                        value="{{ $mk->id_matakuliah }}"
                        {{ old('id_matakuliah')==$mk->id_matakuliah ? 'selected' : '' }}>

                        {{ $mk->kode_matakuliah }}
                        -
                        {{ $mk->nama_matakuliah }}

                    </option>

                    @endforeach

                </select>

                @error('id_matakuliah')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>

            {{-- Nilai --}}
            <div class="mb-3">

                <label class="form-label text-secondary small">
                    Nilai Angka
                </label>

                <input
                    type="number"
                    name="nilai_angka"
                    id="nilai_angka"
                    class="form-control @error('nilai_angka') is-invalid @enderror"
                    min="0"
                    max="100"
                    value="{{ old('nilai_angka') }}">

                @error('nilai_angka')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>

            {{-- Nilai Huruf --}}
            <div class="mb-4">

                <label class="form-label text-secondary small">
                    Nilai Huruf
                </label>

                <div class="grade-box" id="gradeBox">
                    -
                </div>

                <input
                    type="hidden"
                    name="nilai_huruf"
                    id="nilai_huruf"
                    value="{{ old('nilai_huruf') }}">

            </div>

               <div class="d-flex gap-2">
                <button type="submit" class="btn btn-save">
                    <i class="bi bi-check-lg"></i> Simpan
                </button>

                <a href="{{ route('nilai.index') }}" class="btn btn-cancel">
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>

<script>
const nilai = document.getElementById('nilai_angka');
const grade = document.getElementById('gradeBox');
const hidden = document.getElementById('nilai_huruf');

function hitungGrade(){
    let n = parseFloat(nilai.value);
    let h = '-';
    let warna = '#94a3b8';

    if(!isNaN(n)){
        if(n >= 85){
            h = 'A';
            warna = '#22c55e';
        }else if(n >= 70){
            h = 'B';
            warna = '#3b82f6';
        }else if(n >= 55){
            h = 'C';
            warna = '#f59e0b';
        }else {
            h = 'D';
            warna = '#ef4444';
        }
    }

    grade.innerHTML = h;
    grade.style.color = warna;
    hidden.value = (h == '-') ? '' : h;
}

nilai.addEventListener('input', hitungGrade);
window.onload = hitungGrade;
</script>

@endsection