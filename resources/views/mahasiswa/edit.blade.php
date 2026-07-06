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
.form-select{
    background:#020617;
    border:1px solid #334155;
    color:#e2e8f0;
    border-radius:10px;
    padding:10px;
}

.form-control:focus,
.form-select:focus{
    background:#020617;
    color:#fff;
    border-color:#3b82f6;
    box-shadow:none;
}

.input-error{
    color:#ef4444;
    font-size:12px;
    margin-top:5px;
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

<div class="col-lg-8 mx-auto">

    <div class="form-header mb-3">
        <h4 class="mb-1"><i class="bi bi-pencil-square me-2 text-primary"></i>Edit Mahasiswa</h4>
        <p>Perbarui data mahasiswa <strong>{{ $mahasiswa->nama }}</strong></p>
    </div>

    <div class="form-card">

        <form action="{{ route('mahasiswa.update',$mahasiswa->id_mahasiswa) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label text-secondary small">
                        NIM
                    </label>

                    <input
                        type="text"
                        name="nim"
                        value="{{ old('nim',$mahasiswa->nim) }}"
                        class="form-control @error('nim') is-invalid @enderror">

                    @error('nim')
                        <div class="input-error">{{ $message }}</div>
                    @enderror

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label text-secondary small">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        name="nama"
                        value="{{ old('nama',$mahasiswa->nama) }}"
                        class="form-control @error('nama') is-invalid @enderror">

                    @error('nama')
                        <div class="input-error">{{ $message }}</div>
                    @enderror

                </div>

            </div>

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label text-secondary small">
                        Jenis Kelamin
                    </label>

                    <select
                        name="jenis_kelamin"
                        class="form-select">

                        <option value="">Pilih</option>

                        <option value="L"
                            {{ old('jenis_kelamin',$mahasiswa->jenis_kelamin)=='L' ? 'selected' : '' }}>
                            Laki-laki
                        </option>

                        <option value="P"
                            {{ old('jenis_kelamin',$mahasiswa->jenis_kelamin)=='P' ? 'selected' : '' }}>
                            Perempuan
                        </option>

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label text-secondary small">
                        Angkatan
                    </label>

                    <input
                        type="number"
                        name="angkatan"
                        value="{{ old('angkatan',$mahasiswa->angkatan) }}"
                        class="form-control">

                </div>

            </div>

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label text-secondary small">
                        No HP
                    </label>

                    <input
                        type="text"
                        name="no_hp"
                        value="{{ old('no_hp',$mahasiswa->no_hp) }}"
                        class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label text-secondary small">
                        Jurusan
                    </label>

                    <select
                        name="id_jurusan"
                        class="form-select">

                        <option value="">-- Pilih Jurusan --</option>

                        @foreach($jurusans as $j)

                        <option
                            value="{{ $j->id_jurusan }}"
                            {{ old('id_jurusan',$mahasiswa->id_jurusan)==$j->id_jurusan ? 'selected' : '' }}>

                            {{ $j->nama_jurusan }}

                        </option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="mb-4">

                <label class="form-label text-secondary small">
                    Alamat
                </label>

                <textarea
                    name="alamat"
                    rows="4"
                    class="form-control">{{ old('alamat',$mahasiswa->alamat) }}</textarea>

            </div>

        <div class="d-flex justify-content-end gap-2 border-top border-secondary pt-3">
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-cancel d-flex align-items-center">
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