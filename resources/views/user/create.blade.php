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

/* CONTAINER CARD FOR FORM */
.card-form {
    background: #1e293b;
    border-radius: 16px;
    border: 1px solid #334155;
    padding: 28px;
}

/* FORM ELEMENTS */
.form-label {
    color: #94a3b8;
    font-weight: 500;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.form-control-custom {
    background: #020617;
    border: 1px solid #334155;
    color: #ffffff;
    border-radius: 10px;
    padding: 12px 16px;
    height: 48px;
    font-size: 0.95rem;
    transition: 0.2s;
}

.form-control-custom:focus {
    background: #020617;
    color: #ffffff;
    border-color: #3b82f6;
    box-shadow: none;
}

.btn-toggle-eye {
    background: #020617;
    border: 1px solid #334155;
    border-left: none;
    color: #64748b;
    border-top-right-radius: 10px !important;
    border-bottom-right-radius: 10px !important;
    padding: 0 16px;
    transition: 0.2s;
}

.btn-toggle-eye:hover {
    color: #3b82f6;
    background: #020617;
}

/* BUTTONS REGULATION */
.btn-action-form {
    border-radius: 10px;
    padding: 0 24px;
    height: 46px;
    font-weight: 500;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: 0.2s;
    border: none;
}

.btn-back {
    background: #334155;
    color: #e2e8f0;
}

.btn-back:hover {
    background: #475569;
    color: #ffffff;
}

.btn-save {
    background: #3b82f6;
    color: #ffffff;
}

.btn-save:hover {
    background: #2563eb;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}
</style>

{{-- HEADER UTAMA --}}
<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="mb-1">
            <i class="bi bi-person-plus-fill text-primary me-2"></i>Tambah User
        </h4>
        <p class="mb-0">Daftarkan akun pengguna sistem baru beserta hak akses kewenangannya</p>
    </div>
</div>

{{-- BOX CONTAINER FORM --}}
<div class="card-form shadow-lg mb-5">

    {{-- ERROR VALIDATION LIST --}}
    @if($errors->any())
        <div class="alert alert-danger border-0 mb-4" style="border-radius: 12px; background-color: rgba(239, 68, 68, 0.15) !important; color: #f87171 !important;">
            <div class="d-flex gap-2 align-items-start">
                <i class="bi bi-exclamation-triangle-fill mt-1"></i>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('user.store') }}" method="POST">
        @csrf

        <div class="row">
            {{-- NAMA --}}
            <div class="col-md-6 mb-4">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" 
                       name="name" 
                       class="form-control form-control-custom w-100" 
                       value="{{ old('name') }}" 
                       placeholder="Masukkan nama lengkap..."
                       required>
            </div>

            {{-- EMAIL --}}
            <div class="col-md-6 mb-4">
                <label class="form-label">Alamat Email</label>
                <input type="email" 
                       name="email" 
                       class="form-control form-control-custom w-100" 
                       value="{{ old('email') }}" 
                       placeholder="contoh@domain.com"
                       required>
            </div>
        </div>

        <div class="row">
            {{-- ROLE --}}
            <div class="col-md-6 mb-4">
                <label class="form-label">Role / Hak Akses</label>
                <select name="role" 
                        class="form-select form-control-custom w-100" 
                        required>
                    <option value="">-- Pilih Level Otoritas --</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                </select>
            </div>
            
            <div class="col-md-6"></div>
        </div>

        <div class="row">
            {{-- PASSWORD --}}
            <div class="col-md-6 mb-4">
                <label class="form-label" for="password">Password</label>
                <div class="input-group">
                    <input type="password" 
                           id="password"
                           name="password" 
                           class="form-control form-control-custom" 
                           style="border-top-right-radius: 0; border-bottom-right-radius: 0;"
                           placeholder="••••••••"
                           required>
                    <button class="btn btn-toggle-eye" 
                            type="button" 
                            onclick="togglePassword('password', this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            {{-- KONFIRMASI PASSWORD --}}
            <div class="col-md-6 mb-4">
                <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                <div class="input-group">
                    <input type="password" 
                           id="password_confirmation"
                           name="password_confirmation" 
                           class="form-control form-control-custom" 
                           style="border-top-right-radius: 0; border-bottom-right-radius: 0;"
                           placeholder="••••••••"
                           required>
                    <button class="btn btn-toggle-eye" 
                            type="button" 
                            onclick="togglePassword('password_confirmation', this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
        </div>

        <hr class="my-4" style="border-color: #334155;">

        {{-- TOMBOL AKSI --}}
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-action-form btn-save">
                <i class="bi bi-check-circle"></i> Simpan User
            </button>
            <a href="{{ route('user.index') }}" class="btn btn-action-form btn-back">
                Batal
            </a>
            

        </div>

    </form>
</div>

<script>
function togglePassword(id, button) {
    const input = document.getElementById(id);
    const icon = button.querySelector('i');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
        button.style.color = '#3b82f6';
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
        button.style.color = '#64748b';
    }
}
</script>

@endsection