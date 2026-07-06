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

.form-control {
    background: #020617;
    border: 1px solid #334155;
    color: white;
    border-radius: 10px;
    padding: 10px 14px;
}

.form-control:focus {
    background: #020617;
    color: white;
    border-color: #3b82f6;
    box-shadow: none;
}

/* VALIDATION INVALID STATE */
.form-control.is-invalid {
    border-color: #ef4444;
    background-image: none;
}

.form-control.is-invalid:focus {
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

{{-- HEADER --}}
<div class="page-header mb-4">
    <h4 class="mb-1"><i class="bi bi-person-plus-fill me-2 text-primary"></i>Tambah Data Dosen</h4>
    <p class="mb-0">Tambahkan berkas profil dosen baru ke dalam basis data administrasi akademik</p>
</div>

{{-- CARD WRAPPER --}}
<div class="card-form">

    <form action="{{ route('dosen.store') }}" method="POST">
        @csrf

        <div class="row">
            {{-- NIDN --}}
            <div class="col-md-6 mb-3">
                <label class="form-label text-uppercase">NIDN</label>
                <input type="text" 
                       name="nidn" 
                       class="form-control @error('nidn') is-invalid @enderror" 
                       value="{{ old('nidn') }}"
                       placeholder="Masukkan NIDN dosen...">
                
                @error('nidn')
                <div class="invalid-feedback">
                    <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                </div>
                @enderror
            </div>

            {{-- NAMA DOSEN --}}
            <div class="col-md-6 mb-3">
                <label class="form-label text-uppercase">Nama Lengkap</label>
                <input type="text" 
                       name="nama_dosen" 
                       class="form-control @error('nama_dosen') is-invalid @enderror" 
                       value="{{ old('nama_dosen') }}"
                       placeholder="Masukkan nama lengkap beserta gelar...">

                @error('nama_dosen')
                <div class="invalid-feedback">
                    <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        <div class="row">
            {{-- EMAIL --}}
            <div class="col-md-6 mb-3">
                <label class="form-label text-uppercase">Alamat Email</label>
                <input type="email" 
                       name="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email') }}"
                       placeholder="contoh: dosen@utb.ac.id">

                @error('email')
                <div class="invalid-feedback">
                    <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                </div>
                @enderror
            </div>

            {{-- NO HP --}}
            <div class="col-md-6 mb-3">
                <label class="form-label text-uppercase">Nomor WhatsApp / HP</label>
                <input type="text" 
                       name="no_hp" 
                       class="form-control @error('no_hp') is-invalid @enderror" 
                       value="{{ old('no_hp') }}"
                       placeholder="contoh: 08XXXXXXXXXX">

                @error('no_hp')
                <div class="invalid-feedback">
                    <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        {{-- ALAMAT --}}
        <div class="mb-4">
            <label class="form-label text-uppercase">Alamat Tempat Tinggal</label>
            <textarea name="alamat" 
                      rows="4" 
                      class="form-control @error('alamat') is-invalid @enderror"
                      placeholder="Masukkan alamat domisili lengkap saat ini...">{{ old('alamat') }}</textarea>

            @error('alamat')
            <div class="invalid-feedback">
                <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
            </div>
            @enderror
        </div>

        {{-- ACTIONS BUTTONS --}}
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-save">
                    <i class="bi bi-check-lg"></i> Simpan
                </button>

                <a href="{{ route('dosen.index') }}" class="btn btn-cancel">
                    Batal
                </a>
            </div>
    </form>

</div>

@endsection