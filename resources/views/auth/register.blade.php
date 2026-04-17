<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register | Sistem Akademik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: radial-gradient(circle at top left, #1e293b, #0f172a);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            color: white;
        }
        .login-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .form-control {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid #334155;
            color: white;
            padding: 12px;
        }
        .form-control:focus {
            background: rgba(15, 23, 42, 0.8);
            border-color: #3b82f6;
            color: white;
            box-shadow: none;
        }
        .input-group-text {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid #334155;
            color: #94a3b8;
            cursor: pointer;
        }
        .btn-login {
            background: linear-gradient(to right, #3b82f6, #2563eb);
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="login-card text-center">
    <h3 class="fw-bold text-white mb-1">Sistem<span class="text-primary">Akademik</span></h3>
    <p class="text-secondary mb-4 small">Buat akun untuk mulai menggunakan sistem</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3 text-start">
            <label class="text-secondary small mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required autofocus>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3 text-start">
            <label class="text-secondary small mb-1">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3 text-start">
            <label class="text-secondary small mb-1">Password</label>
            <div class="input-group">
                <input type="password" name="password" id="reg_password" class="form-control @error('password') is-invalid @enderror" required>
                <span class="input-group-text" onclick="togglePassword('reg_password', 'eye-reg')">
                    <i class="bi bi-eye-slash" id="eye-reg"></i>
                </span>
            </div>
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-4 text-start">
            <label class="text-secondary small mb-1">Konfirmasi Password</label>
            <div class="input-group">
                <input type="password" name="password_confirmation" id="reg_confirm" class="form-control" required>
                <span class="input-group-text" onclick="togglePassword('reg_confirm', 'eye-confirm')">
                    <i class="bi bi-eye-slash" id="eye-confirm"></i>
                </span>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-login w-100 mb-3">Sign Up</button>
    </form>

    <p class="text-white small mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="text-primary text-decoration-none">Login</a></p>
</div>

<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === "password") {
            input.type = "text";
            icon.classList.replace("bi-eye-slash", "bi-eye");
        } else {
            input.type = "password";
            icon.classList.replace("bi-eye", "bi-eye-slash");
        }
    }
</script>
</body>
</html>