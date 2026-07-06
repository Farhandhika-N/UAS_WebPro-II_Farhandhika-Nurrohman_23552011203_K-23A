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
        <h4 class="mb-1"><i class="bi bi-pencil-square me-2 text-primary"></i>Edit Jurusan</h4>
        <p>Perbarui data jurusan: <strong>{{ $jurusan->nama_jurusan }}</strong></p>
    </div>

    <div class="form-card">

        <form action="{{ route('jurusan.update', $jurusan->id_jurusan) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- NAMA --}}
            <div class="mb-3">
                <label class="form-label text-secondary small">Nama Jurusan</label>
                <input type="text" name="nama_jurusan"
                    value="{{ old('nama_jurusan', $jurusan->nama_jurusan) }}"
                    class="form-control">

                @error('nama_jurusan')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- AKREDITASI --}}
            <div class="mb-4">
                <label class="form-label text-secondary small">Akreditasi</label>
                <select name="akreditasi" class="form-select">
                    @foreach(['A', 'B', 'C'] as $acr)
                        <option value="{{ $acr }}"
                            {{ $jurusan->akreditasi == $acr ? 'selected' : '' }}>
                            {{ $acr }}
                        </option>
                    @endforeach
                </select>

                @error('akreditasi')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- ACTION --}}
            <div class="d-flex justify-content-end gap-2 border-top border-secondary pt-3">
                <a href="{{ route('jurusan.index') }}" class="btn btn-cancel d-flex align-items-center">
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