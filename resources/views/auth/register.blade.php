<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SINEMANIS</title>
    
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
            padding: 20px 0;
        }
        
        .register-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            max-width: 800px;
            width: 100%;
            padding: 40px;
            margin: 0 auto;
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
        
        .info-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            border-left: 4px solid var(--primary-color);
        }
        
        .step-list {
            list-style: none;
            padding: 0;
        }
        
        .step-list li {
            padding: 8px 0;
            border-bottom: 1px solid #dee2e6;
        }
        
        .step-list li:last-child {
            border-bottom: none;
        }
        
        .step-number {
            display: inline-block;
            background: var(--primary-color);
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            text-align: center;
            line-height: 24px;
            font-size: 12px;
            font-weight: bold;
            margin-right: 10px;
        }
        
        .form-text.success {
            color: #198754;
        }
        
        .form-text.danger {
            color: #dc3545;
        }
        
        .form-text.warning {
            color: #ffc107;
        }
        
        @media (max-width: 768px) {
            .register-container {
                padding: 30px 20px;
                margin: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Back to Home Button -->
    <a href="{{ route('home') }}" class="back-btn" title="Kembali ke Beranda">
        <i class="fas fa-arrow-left me-2"></i>Beranda
    </a>

    <div class="container">
        <div class="register-container">
            <!-- Logo Section -->
            <div class="logo-section">
                <img src="images/logo.png" alt="SINEMANIS Logo">
                <h3 class="fw-bold text-primary mt-2">SINEMANIS</h3>
                <p class="text-muted">Sistem Penerimaan Mahasiswa Baru</p>
            </div>
            
            <!-- Register Form -->
            <div class="text-center mb-4">
                <h4 class="fw-bold">Buat Akun Baru</h4>
                <p class="text-muted">Lengkapi form di bawah untuk memulai pendaftaran</p>
            </div>
            
            <form action="{{ route('register.post') }}" method="POST">
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
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">
                            <i class="fas fa-user me-2"></i>Nama Lengkap
                        </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" 
                               placeholder="Masukkan nama lengkap" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-2"></i>Email
                        </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" 
                               placeholder="Masukkan email aktif" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="phone" class="form-label">
                        <i class="fas fa-phone me-2"></i>Nomor Telepon
                    </label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                           id="phone" name="phone" value="{{ old('phone') }}" 
                           placeholder="Contoh: 08123456789">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i>Password
                        </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" 
                               placeholder="Minimal 8 karakter" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="password-strength" class="form-text"></div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">
                            <i class="fas fa-lock me-2"></i>Konfirmasi Password
                        </label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" 
                               placeholder="Ulangi password" required>
                        <div id="confirm-password-feedback" class="form-text"></div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input @error('terms') is-invalid @enderror" 
                               type="checkbox" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">
                            Saya menyetujui 
                            <a href="#" class="link-custom" data-bs-toggle="modal" data-bs-target="#termsModal">syarat dan ketentuan</a> 
                            yang berlaku
                        </label>
                        @error('terms')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 mb-3">
                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                </button>
            </form>
            
            <div class="text-center">
                <p class="mb-2">Sudah memiliki akun?</p>
                <a href="{{ route('login') }}" class="link-custom">
                    <i class="fas fa-sign-in-alt me-2"></i>Masuk ke Akun
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
    
    <!-- Terms Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-primary" id="termsModalLabel">
                        <i class="fas fa-file-contract me-2"></i>Syarat dan Ketentuan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6 class="fw-bold text-primary">1. Ketentuan Umum</h6>
                    <p>Dengan mendaftar di Universitas Selamat Sri, calon mahasiswa menyetujui untuk mematuhi semua peraturan dan ketentuan yang berlaku.</p>
                    
                    <h6 class="fw-bold text-primary">2. Data Pribadi</h6>
                    <p>Semua data yang dimasukkan harus valid dan dapat dipertanggungjawabkan. Universitas berhak memverifikasi kebenaran data yang diberikan.</p>
                    
                    <h6 class="fw-bold text-primary">3. Biaya Pendaftaran</h6>
                    <p>Biaya pendaftaran yang telah dibayarkan tidak dapat dikembalikan dalam kondisi apapun.</p>
                    
                    <h6 class="fw-bold text-primary">4. Proses Seleksi</h6>
                    <p>Keputusan penerimaan mahasiswa baru sepenuhnya berada di tangan panitia penerimaan dan tidak dapat diganggu gugat.</p>
                    
                    <h6 class="fw-bold text-primary">5. Privasi Data</h6>
                    <p>Universitas Selamat Sri berkomitmen melindungi privasi data pribadi sesuai dengan undang-undang yang berlaku.</p>
                    
                    <div class="alert alert-info mt-3">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Penting:</strong> Dengan menyetujui syarat dan ketentuan ini, Anda memahami dan menerima semua ketentuan yang berlaku.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto focus on name field
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('name').focus();
        });
        
        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const strengthDiv = document.getElementById('password-strength');
        const confirmDiv = document.getElementById('confirm-password-feedback');
        
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (/\d/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength++;
            
            if (password.length > 0) {
                if (strength < 2) {
                    strengthDiv.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Password lemah';
                    strengthDiv.className = 'form-text danger';
                } else if (strength < 3) {
                    strengthDiv.innerHTML = '<i class="fas fa-check me-1"></i>Password sedang';
                    strengthDiv.className = 'form-text warning';
                } else {
                    strengthDiv.innerHTML = '<i class="fas fa-check-circle me-1"></i>Password kuat';
                    strengthDiv.className = 'form-text success';
                }
            } else {
                strengthDiv.innerHTML = '';
            }
        });
        
        // Confirm password validation
        confirmPasswordInput.addEventListener('input', function() {
            const password = passwordInput.value;
            const confirmPassword = this.value;
            
            if (confirmPassword.length > 0) {
                if (password === confirmPassword) {
                    confirmDiv.innerHTML = '<i class="fas fa-check-circle me-1"></i>Password cocok';
                    confirmDiv.className = 'form-text success';
                    this.classList.remove('is-invalid');
                } else {
                    confirmDiv.innerHTML = '<i class="fas fa-times-circle me-1"></i>Password tidak cocok';
                    confirmDiv.className = 'form-text danger';
                    this.classList.add('is-invalid');
                }
            } else {
                confirmDiv.innerHTML = '';
                this.classList.remove('is-invalid');
            }
        });
        
        // Form validation before submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            const termsCheckbox = document.getElementById('terms');
            
            if (password !== confirmPassword) {
                e.preventDefault();
                confirmPasswordInput.focus();
                return false;
            }
            
            if (!termsCheckbox.checked) {
                e.preventDefault();
                termsCheckbox.focus();
                return false;
            }
        });
        
        // Phone number formatting
        document.getElementById('phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length > 0 && !value.startsWith('08') && !value.startsWith('62')) {
                if (value.startsWith('8')) {
                    value = '0' + value;
                }
            }
            
            e.target.value = value;
        });
    </script>
</body>
</html>