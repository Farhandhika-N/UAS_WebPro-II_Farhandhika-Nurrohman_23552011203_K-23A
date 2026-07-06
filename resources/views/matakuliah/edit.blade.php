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

<div class="col-md-6 mx-auto">

    <div class="form-header mb-3">
        <h4 class="mb-1"><i class="bi bi-pencil-square me-2 text-primary"></i>Edit Matakuliah</h4>
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

            <div class="mb-3">
                <label>Dosen Pengampu</label>

                <select
                name="id_dosen"
                class="form-select">

                <option value="">-- Pilih Dosen --</option>

                @foreach($dosens as $d)

                <option
                value="{{ $d->id_dosen }}"
                {{ old('id_dosen',$matakuliah->id_dosen)==$d->id_dosen?'selected':'' }}>

                {{ $d->nama_dosen }}

                </option>

                @endforeach

                </select>

            </div>

            {{-- ACTION --}}
            <div class="d-flex justify-content-end gap-2 border-top border-secondary pt-3">
                <a href="{{ route('matakuliah.index') }}" class="btn btn-cancel d-flex align-items-center">
                    Batal
                </a>
                <button type="submit" class="btn btn-save d-flex align-items-center">
                    <i class="bi bi-arrow-clockwise me-2"></i> Perbarui Data
                </button>
            </div>

        </form>

    </div>
</div>

@endsection