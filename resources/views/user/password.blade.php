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
    max-width: 650px;
    margin: 0 auto;
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

/* READONLY CONTROL STATE */
.form-control-custom[readonly] {
    background: #0f172a;
    color: #64748b;
    border-color: #1e293b;
    cursor: not-allowed;
}

/* PASSWORD EYE BUTTON Toggle */
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
<div class="page-header mb-4 text-center text-md-start" style="max-width: 650px; margin: 0 auto;">
    <h4 class="mb-1">
        <i class="bi bi-key-fill text-info me-2"></i>Ganti Password User
    </h4>
    <p class="mb-0">Perbarui kredensial keamanan enkripsi sandi untuk akun pengguna sistem ini</p>
</div>

{{-- BOX CONTAINER FORM --}}
<div class="card-form shadow-lg mb-5">
    <form action="{{ route('user.password.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- NAMA USER --}}
        <div class="mb-4">
            <label class="form-label">Nama Pengguna</label>
            <input type="text" 
                   class="form-control form-control-custom w-100" 
                   value="{{ $user->name }}" 
                   readonly>
        </div>

        {{-- EMAIL --}}
        <div class="mb-4">
            <label class="form-label">Alamat Email</label>
            <input type="text" 
                   class="form-control form-control-custom w-100" 
                   value="{{ $user->email }}" 
                   readonly>
        </div>

        <hr class="my-4" style="border-color: #334155;">

        {{-- PASSWORD BARU --}}
        <div class="mb-4">
            <label class="form-label" for="password">Password Baru</label>
            <div class="input-group">
                <input type="password" 
                       id="password" 
                       name="password" 
                       class="form-control form-control-custom @error('password') is-invalid @enderror" 
                       style="border-top-right-radius: 0; border-bottom-right-radius: 0;"
                       required>
                
                <button class="btn btn-toggle-eye" 
                        type="button" 
                        onclick="togglePassword('password', this)">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
            
            @error('password')
                <div class="text-danger small mt-2 d-flex align-items-center gap-1">
                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        {{-- KONFIRMASI PASSWORD --}}
        <div class="mb-5">
            <label class="form-label" for="password_confirmation">Konfirmasi Password Baru</label>
            <div class="input-group">
                <input type="password" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       class="form-control form-control-custom" 
                       style="border-top-right-radius: 0; border-bottom-right-radius: 0;"
                       required>
                
                <button class="btn btn-toggle-eye" 
                        type="button" 
                        onclick="togglePassword('password_confirmation', this)">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
        </div>

        {{-- TOMBOL AKSI --}}
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('user.index') }}" class="btn btn-action-form btn-back">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            
            <button type="submit" class="btn btn-action-form btn-save">
                <i class="bi bi-check-circle"></i> Simpan Sandi
            </button>
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