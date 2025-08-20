<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SINEMANIS</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #2E3192;
            --secondary-color: #1BAEEC;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .login-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
            padding: 40px;
        }
        
        .logo-section {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo-section img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 15px;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 12px;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .form-control {
            padding: 12px 16px;
            border-radius: 8px;
        }
        
        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(27, 174, 236, 0.25);
        }
        
        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background: white;
            color: var(--primary-color);
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 8px 12px;
            text-decoration: none;
        }
        
        .back-btn:hover {
            background: #f8f9fa;
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .link-custom {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }
        
        .link-custom:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }
        
        .university-info {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 4px solid var(--primary-color);
        }
        
        .university-info h6 {
            color: var(--primary-color);
            margin-bottom: 8px;
        }
        
        .university-info p {
            margin-bottom: 0;
            font-size: 14px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <!-- Back to Home Button -->
    <a href="{{ route('home') }}" class="back-btn" title="Kembali ke Beranda">
        <i class="fas fa-arrow-left me-2"></i>Beranda
    </a>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="login-container mx-auto">
                    <!-- Logo Section -->
                    <div class="logo-section">
                        <img src="images/logo.png" alt="SINEMANIS Logo">
                        <h3 class="fw-bold text-primary mt-2">SINEMANIS</h3>
                        <p class="text-muted">Sistem Penerimaan Mahasiswa Baru</p>
                    </div>
                    
                    <!-- Login Form -->
                    <div class="text-center mb-4">
                        <h4 class="fw-bold">Masuk</h4>
                        <p class="text-muted">Silakan masuk dengan kredensial Anda</p>
                    </div>
                    
                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        
                        <!-- Alert Messages -->
                        @if(session('success'))
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            </div>
                        @endif
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-2"></i>Email
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="Masukkan email Anda" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Password
                            </label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" 
                                   placeholder="Masukkan password Anda" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    Ingat saya
                                </label>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="fas fa-sign-in-alt me-2"></i>Masuk
                        </button>
                    </form>
                    
                    <div class="text-center">
                        <p class="mb-2">Belum memiliki akun?</p>
                        <a href="{{ route('register') }}" class="link-custom">
                            <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                        </a>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="text-center">
                        <small class="text-muted">
                            Butuh bantuan? Hubungi 
                            <a href="tel:+6212345678900" class="link-custom">+62 821 2279 0309</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto focus on email field
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('email').focus();
        });
        
        // Simple form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            
            if (!email.value || !password.value) {
                e.preventDefault();
                if (!email.value) email.focus();
                else if (!password.value) password.focus();
            }
        });
    </script>
</body>
</html>