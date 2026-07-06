@extends('layouts.app')

@section('content')

<style>
/* CARD FORM */
.form-card {
    background: #1e293b;
    border-radius: 16px;
    border: 1px solid #334155;
    padding: 25px;
}

/* HEADER */
.form-header h4 {
    font-weight: 600;
}

.form-header p {
    color: #94a3b8;
    font-size: 0.85rem;
}

/* INPUT */
.form-control,
.form-select {
    background: #020617;
    border: 1px solid #334155;
    color: #e2e8f0;
    border-radius: 10px;
    padding: 10px;
}

.form-control:focus,
.form-select:focus {
    border-color: #3b82f6;
    box-shadow: none;
    background: #020617;
    color: white;
}

/* ERROR */
.input-error {
    font-size: 12px;
    color: #ef4444;
    margin-top: 5px;
}

/* BUTTON */
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

<div class="col-md-6 mx-auto">

    <div class="form-header mb-3">
        <h4>Tambah Jurusan</h4>
        <p>Tambahkan data jurusan baru ke sistem akademik</p>
    </div>

    <div class="form-card">

        <form action="{{ route('jurusan.store') }}" method="POST">
            @csrf

            {{-- NAMA --}}
            <div class="mb-3">
                <label class="form-label text-secondary small">Nama Jurusan</label>
                <input type="text" name="nama_jurusan"
                    value="{{ old('nama_jurusan') }}"
                    class="form-control @error('nama_jurusan') is-invalid @enderror"
                    placeholder="Contoh: Teknik Informatika">

                @error('nama_jurusan')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- AKREDITASI --}}
            <div class="mb-4">
                <label class="form-label text-secondary small">Akreditasi</label>
                <select name="akreditasi"
                    class="form-select @error('akreditasi') is-invalid @enderror">
                    <option value="">-- Pilih Akreditasi --</option>
                    <option value="A">A (Sangat Baik)</option>
                    <option value="B">B (Baik)</option>
                    <option value="C">C (Cukup)</option>
                </select>

                @error('akreditasi')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- ACTION --}}
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-save">
                    <i class="bi bi-check-lg"></i> Simpan
                </button>

                <a href="{{ route('jurusan.index') }}" class="btn btn-cancel">
                    Batal
                </a>

        </form>

    </div>
</div>

@endsection