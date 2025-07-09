@extends('pengguna.layouts.app')

@section('content')
    @push('styles')
        <style>
            /* Login Page Styles */
            .login-page {
                background: linear-gradient(135deg, #3ab8ff 0%, #377D98 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                position: relative;
                overflow: hidden;
            }

            .login-page::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><polygon points="0,100 1000,0 1000,100"/></svg>');
                background-size: cover;
            }

            .login-container {
                background: white;
                border-radius: 20px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                position: relative;
                z-index: 2;
                max-width: 900px;
                width: 100%;
            }

            .login-left {
                background: linear-gradient(135deg, #3ab8ff, #377D98);
                color: white;
                padding: 50px 40px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                position: relative;
                overflow: hidden;
            }

            .login-left::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="white" opacity="0.1"><circle cx="50" cy="50" r="40"/></svg>');
                background-size: 50px 50px;
            }

            .login-left .content {
                position: relative;
                z-index: 2;
            }

            .login-left h2 {
                font-size: 2.5rem;
                font-weight: 700;
                margin-bottom: 20px;
            }

            .login-left p {
                font-size: 1.1rem;
                opacity: 0.9;
                line-height: 1.7;
                margin-bottom: 30px;
            }

            .login-right {
                padding: 50px 40px;
            }

            .login-form h3 {
                font-size: 2rem;
                font-weight: 700;
                color: #333;
                margin-bottom: 10px;
            }

            .login-form .subtitle {
                color: #666;
                margin-bottom: 40px;
                font-size: 1.1rem;
            }

            .form-group {
                margin-bottom: 25px;
                position: relative;
            }

            .form-label {
                font-weight: 600;
                color: #333;
                margin-bottom: 8px;
                display: block;
            }

            .form-control {
                border: 2px solid #eee;
                border-radius: 12px;
                padding: 15px 20px;
                font-size: 1rem;
                transition: all 0.3s ease;
                width: 100%;
                background: #f8f9fa;
            }

            .form-control:focus {
                outline: none;
                border-color: #3ab8ff;
                background: white;
                box-shadow: 0 0 0 3px rgba(58, 184, 255, 0.1);
            }

            .input-group {
                position: relative;
            }

            .input-group .form-control {
                padding-left: 50px;
            }

            .input-icon {
                position: absolute;
                left: 18px;
                top: 50%;
                transform: translateY(-50%);
                color: #666;
                z-index: 3;
            }

            .password-toggle {
                position: absolute;
                right: 18px;
                top: 50%;
                transform: translateY(-50%);
                color: #666;
                cursor: pointer;
                z-index: 3;
            }

            .btn-login {
                background: linear-gradient(135deg, #3ab8ff, #377D98);
                border: none;
                color: white;
                padding: 15px 30px;
                border-radius: 12px;
                font-size: 1.1rem;
                font-weight: 600;
                width: 100%;
                transition: all 0.3s ease;
                margin-top: 10px;
            }

            .btn-login:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(58, 184, 255, 0.3);
                color: white;
            }

            .btn-login:disabled {
                opacity: 0.6;
                transform: none;
                box-shadow: none;
            }

            .forgot-link {
                color: #3ab8ff;
                text-decoration: none;
                font-weight: 500;
                text-align: center;
                display: block;
                margin-top: 20px;
                transition: all 0.3s ease;
            }

            .forgot-link:hover {
                color: #377D98;
                text-decoration: underline;
            }

            .divider {
                text-align: center;
                margin: 30px 0;
                position: relative;
            }

            .divider::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 0;
                right: 0;
                height: 1px;
                background: #eee;
            }

            .divider span {
                background: white;
                padding: 0 20px;
                color: #666;
                font-size: 0.9rem;
            }

            .register-link {
                text-align: center;
                margin-top: 30px;
                padding-top: 20px;
                border-top: 1px solid #eee;
            }

            .register-link a {
                color: #3ab8ff;
                text-decoration: none;
                font-weight: 600;
            }

            .register-link a:hover {
                color: #377D98;
                text-decoration: underline;
            }

            /* Brand Logo Styles */
            .brand-logo {
                margin-bottom: 30px;
            }

            .brand-name {
                font-size: 3rem;
                font-weight: 900;
                letter-spacing: 2px;
                margin-bottom: 8px;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            }

            .brand-tagline {
                font-size: 1rem;
                opacity: 0.9;
                font-weight: 500;
                margin-bottom: 20px;
            }

            .welcome-subtitle {
                font-size: 1.1rem;
                opacity: 0.9;
                line-height: 1.6;
                margin-bottom: 30px;
            }

            /* Enhanced Link Styles */
            .register-btn {
                color: #3ab8ff !important;
                text-decoration: none !important;
                font-weight: 700 !important;
                font-size: 1.1rem;
                transition: all 0.3s ease;
            }

            .register-btn:hover {
                color: #377D98 !important;
                text-decoration: underline !important;
            }

            .partner-login-btn {
                color: #28a745 !important;
                text-decoration: none !important;
                font-weight: 600;
                font-size: 1rem;
                padding: 10px 20px;
                border-radius: 8px;
                background: rgba(40, 167, 69, 0.1);
                display: inline-block;
                transition: all 0.3s ease;
                margin-top: 10px;
            }

            .partner-login-btn:hover {
                background: rgba(40, 167, 69, 0.2);
                transform: translateY(-1px);
                color: #1e7e34 !important;
            }

            /* Alert Styles */
            .alert {
                border-radius: 12px;
                padding: 15px 20px;
                margin-bottom: 25px;
                border: none;
            }

            .alert-danger {
                background: linear-gradient(135deg, #ff6b6b, #ee5a52);
                color: white;
            }

            /* Responsive Design */
            @media (max-width: 991.98px) {
                .login-left {
                    padding: 40px 30px;
                    text-align: center;
                }

                .brand-name {
                    font-size: 2.5rem;
                }

                .login-left h2 {
                    font-size: 2rem;
                }

                .login-right {
                    padding: 40px 30px;
                }
            }

            @media (max-width: 767.98px) {
                .login-page {
                    padding: 20px;
                    align-items: flex-start;
                    min-height: auto;
                }

                .login-container {
                    margin: 20px 0;
                }

                .login-left {
                    padding: 30px 20px;
                }

                .brand-name {
                    font-size: 2rem;
                }

                .brand-tagline {
                    font-size: 0.9rem;
                }

                .login-left h2 {
                    font-size: 1.75rem;
                }

                .welcome-subtitle {
                    font-size: 1rem;
                }

                .login-right {
                    padding: 30px 20px;
                }

                .login-form h3 {
                    font-size: 1.5rem;
                }

                .form-control {
                    padding: 12px 15px;
                }

                .input-group .form-control {
                    padding-left: 45px;
                }

                .input-icon {
                    left: 15px;
                }

                .password-toggle {
                    right: 15px;
                }

                .register-btn {
                    font-size: 1rem !important;
                }

                .partner-login-btn {
                    font-size: 0.9rem;
                    padding: 8px 16px;
                }
            }

            @media (max-width: 575.98px) {
                .login-container {
                    border-radius: 0;
                    margin: 0;
                }

                .login-left,
                .login-right {
                    padding: 25px 20px;
                }

                .brand-name {
                    font-size: 1.75rem;
                    letter-spacing: 1px;
                }

                .register-link {
                    text-align: center;
                }

                .partner-login-btn {
                    display: block;
                    text-align: center;
                    margin: 10px auto 0;
                    width: fit-content;
                }
            }
        </style>
    @endpush

    <div class="login-page">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="login-container">
                        <div class="row g-0">
                            <!-- Left Side - Welcome -->
                            <div class="col-lg-6">
                                <div class="login-left">
                                    <div class="content text-center">
                                        <div class="brand-logo mb-4">
                                            <h1 class="brand-name">HANDY GO</h1>
                                            <div class="brand-tagline">Solusi Terpercaya untuk Kebutuhan Anda</div>
                                        </div>

                                        <h2>SELAMAT DATANG KEMBALI</h2>
                                        <p class="welcome-subtitle">
                                            Login dan temukan solusi terbaik untuk kebutuhan Anda.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Side - Login Form -->
                            <div class="col-lg-6">
                                <div class="login-right">
                                    <div class="login-form">
                                        <h3>Masuk ke Akun Anda</h3>
                                        <p class="subtitle">Akses semua layanan dengan mudah</p>

                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <i class="fas fa-exclamation-circle me-2"></i>
                                                <strong>Terjadi kesalahan:</strong>
                                                <ul class="mb-0 mt-2">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <form method="POST" action="{{ route('customer.login.post') }}" id="loginForm">
                                            @csrf

                                            <div class="form-group">
                                                <label for="email" class="form-label">
                                                    <i class="fas fa-envelope me-1"></i>Email
                                                </label>
                                                <div class="input-group">
                                                    <i class="input-icon fas fa-envelope"></i>
                                                    <input type="email" class="form-control" id="email" name="email"
                                                        value="{{ old('email') }}" placeholder="Enter your email address"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="password" class="form-label">
                                                    <i class="fas fa-lock me-1"></i>Password
                                                </label>
                                                <div class="input-group">
                                                    <i class="input-icon fas fa-lock"></i>
                                                    <input type="password" class="form-control" id="password"
                                                        name="password" placeholder="***************" required>
                                                    <i class="password-toggle fas fa-eye" onclick="togglePassword()"></i>
                                                </div>
                                            </div>

                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" id="remember"
                                                    name="remember">
                                                <label class="form-check-label" for="remember">
                                                    Ingat saya
                                                </label>
                                            </div>

                                            <button type="submit" class="btn-login" id="loginBtn">
                                                <i class="fas fa-sign-in-alt me-2"></i>
                                                Masuk
                                            </button>
                                        </form>

                                        <a href="#" class="forgot-link">
                                            <i class="fas fa-key me-1"></i>
                                            Lupa Password?
                                        </a>

                                        <div class="divider">
                                            <span>Atau</span>
                                        </div>

                                        <div class="register-link">
                                            <p class="mb-2">
                                                Pengguna Baru?
                                                <a href="#" class="register-btn">DAFTAR DISINI</a>
                                            </p>
                                            <p class="mb-0">
                                                <a href="#" class="partner-login-btn">
                                                    <i class="fas fa-user-tie me-1"></i>
                                                    LOGIN SEBAGAI MITRA
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Toggle password visibility
            function togglePassword() {
                const passwordInput = document.getElementById('password');
                const passwordToggle = document.querySelector('.password-toggle');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    passwordToggle.classList.remove('fa-eye');
                    passwordToggle.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    passwordToggle.classList.remove('fa-eye-slash');
                    passwordToggle.classList.add('fa-eye');
                }
            }

            // Form submission with loading state
            document.getElementById('loginForm').addEventListener('submit', function(e) {
                const loginBtn = document.getElementById('loginBtn');
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;

                // Basic validation
                if (!email || !password) {
                    e.preventDefault();
                    alert('Harap isi semua field yang diperlukan!');
                    return;
                }

                // Show loading state
                loginBtn.disabled = true;
                loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';

                // Re-enable button after 5 seconds (fallback)
                setTimeout(() => {
                    loginBtn.disabled = false;
                    loginBtn.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>Masuk Sekarang';
                }, 5000);
            });

            // Input focus effects
            document.querySelectorAll('.form-control').forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentNode.querySelector('.input-icon').style.color = '#3ab8ff';
                });

                input.addEventListener('blur', function() {
                    this.parentNode.querySelector('.input-icon').style.color = '#666';
                });
            });

            // Handle enter key in form
            document.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const loginForm = document.getElementById('loginForm');
                    if (loginForm) {
                        loginForm.submit();
                    }
                }
            });
        </script>
    @endpush

@endsection
