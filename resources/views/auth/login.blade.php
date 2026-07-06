<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistem Akademik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: radial-gradient(circle at top left, #1e293b, #0f172a);
            min-height: 100vh; 
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            color: white;
            padding: 20px; 
        }
        .login-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        
        @media (max-width: 480px) {
            .login-card {
                padding: 30px 20px;
            }
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
        .invalid-feedback {
            font-size: 0.85rem;
            color: #fb7185;
        }
        .btn-login {
            background: linear-gradient(to right, #3b82f6, #2563eb);
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 10px;
            transition: 0.3s;
        }
        .btn-login:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    <div class="login-card text-center">
        <h3 class="fw-bold text-white mb-1">Sistem<span class="text-primary">Akademik</span></h3>
        <p class="text-secondary mb-4 small">Silakan masuk untuk mengelola data</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-3 text-start">
                <label class="text-secondary small mb-1">Email Address</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4 text-start">
                <label class="text-secondary small mb-1">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                    <span class="input-group-text" onclick="togglePassword('password', 'eye-icon')">
                        <i class="bi bi-eye-slash" id="eye-icon"></i>
                    </span>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 form-check text-start">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label text-secondary small" for="remember">Ingat Saya</label>
            </div>

            <button type="submit" class="btn btn-primary btn-login w-100 mb-3">Sign In</button>
        </form>
        
        <p class="text-white small mb-0">Belum punya akun? <a href="{{ route('register') }}" class="text-primary text-decoration-none">Daftar</a></p>
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