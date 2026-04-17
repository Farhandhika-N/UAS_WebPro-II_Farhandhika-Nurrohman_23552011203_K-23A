@extends('layouts.app')

@section('content')

<style>
/* REUSE STYLE */
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
    font-size: 0.85rem;
}

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

.input-error {
    font-size: 12px;
    color: #ef4444;
    margin-top: 5px;
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

<div class="col-md-6 mx-auto">

    <div class="form-header mb-3">
        <h4>Edit Matakuliah</h4>
        <p>Perbarui data matakuliah: <strong>{{ $matakuliah->nama_matakuliah }}</strong></p>
    </div>

    <div class="form-card">

        <form action="{{ route('matakuliah.update', $matakuliah->id_matakuliah) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- NAMA --}}
            <div class="mb-3">
                <label class="form-label text-secondary small">Nama Matakuliah</label>
                <input type="text" name="nama_matakuliah"
                    value="{{ old('nama_matakuliah', $matakuliah->nama_matakuliah) }}"
                    class="form-control @error('nama_matakuliah') is-invalid @enderror">

                @error('nama_matakuliah')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- SKS --}}
            <div class="mb-3">
                <label class="form-label text-secondary small">Jumlah SKS</label>
                <input type="number" name="sks"
                    value="{{ old('sks', $matakuliah->sks) }}"
                    min="1" max="6"
                    class="form-control @error('sks') is-invalid @enderror">

                @error('sks')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- JURUSAN --}}
            <div class="mb-4">
                <label class="form-label text-secondary small">Jurusan Pengampu</label>
                <select name="id_jurusan"
                    class="form-select @error('id_jurusan') is-invalid @enderror">

                    <option value="">-- Pilih Jurusan --</option>

                    @foreach($jurusans as $j)
                        <option value="{{ $j->id_jurusan }}"
                            {{ old('id_jurusan', $matakuliah->id_jurusan) == $j->id_jurusan ? 'selected' : '' }}>
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
                    <i class="bi bi-save"></i> Update
                </button>

                <a href="{{ route('matakuliah.index') }}" class="btn btn-cancel">
                    Batal
                </a>
            </div>

        </form>

    </div>
</div>

@endsection