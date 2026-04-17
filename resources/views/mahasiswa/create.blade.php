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
        <h4>Tambah Mahasiswa</h4>
        <p>Tambahkan data mahasiswa baru ke sistem akademik</p>
    </div>

    <div class="form-card">

        <form action="{{ route('mahasiswa.store') }}" method="POST">
            @csrf

            {{-- NIM --}}
            <div class="mb-3">
                <label class="form-label text-secondary small">NIM</label>
                <input type="text" name="nim"
                    value="{{ old('nim') }}"
                    class="form-control @error('nim') is-invalid @enderror"
                    placeholder="Contoh: 221001">

                @error('nim')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- NAMA --}}
            <div class="mb-3">
                <label class="form-label text-secondary small">Nama Lengkap</label>
                <input type="text" name="nama"
                    value="{{ old('nama') }}"
                    class="form-control @error('nama') is-invalid @enderror"
                    placeholder="Contoh: Budi Santoso">

                @error('nama')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- JURUSAN --}}
            <div class="mb-4">
                <label class="form-label text-secondary small">Jurusan</label>
                <select name="id_jurusan"
                    class="form-select @error('id_jurusan') is-invalid @enderror">

                    <option value="">-- Pilih Jurusan --</option>

                    @foreach($jurusans as $j)
                        <option value="{{ $j->id_jurusan }}"
                            {{ old('id_jurusan') == $j->id_jurusan ? 'selected' : '' }}>
                            {{ $j->nama_jurusan }}
                        </option>
                    @endforeach

                </select>

                @error('id_jurusan')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- ACTION --}}
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-save">
                    <i class="bi bi-check-lg"></i> Simpan
                </button>

                <a href="{{ route('mahasiswa.index') }}" class="btn btn-cancel">
                    Batal
                </a>
            </div>

        </form>

    </div>
</div>

@endsection