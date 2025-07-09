<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HandyGo</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #3ab8ff 0%, #377D98 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 80px 0;
            margin: 0;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(15px);
            border-radius: 25px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header-section {
            background: linear-gradient(135deg, #3ab8ff, #377D98);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="white" opacity="0.1"><circle cx="20" cy="20" r="3"/><circle cx="80" cy="80" r="4"/><circle cx="40" cy="70" r="2"/><circle cx="90" cy="30" r="3"/></svg>');
            background-size: 100px 100px;
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .brand-logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .brand-logo img {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }

        .brand-title {
            font-size: 3rem;
            font-weight: 900;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            letter-spacing: 1px;
        }

        .brand-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 0.5rem;
        }

        .brand-description {
            font-size: 1rem;
            opacity: 0.8;
            margin-bottom: 0;
        }

        .options-section {
            padding: 3rem 2rem;
        }

        .login-option {
            padding: 2.5rem 2rem;
            text-align: center;
            transition: all 0.4s ease;
            border-radius: 20px;
            margin: 15px;
            position: relative;
            overflow: hidden;
            border: 2px solid transparent;
        }

        .login-option::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .login-option:hover::before {
            left: 100%;
        }

        .login-option:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .customer-option {
            background: linear-gradient(135deg, #3ab8ff, #2196F3);
            color: white;
        }

        .provider-option {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .admin-option {
            background: linear-gradient(135deg, #dc3545, #e83e8c);
            color: white;
        }

        .option-icon {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 2;
        }

        .option-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
            z-index: 2;
        }

        .option-description {
            font-size: 1rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            line-height: 1.6;
            position: relative;
            z-index: 2;
        }

        .btn-custom {
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            padding: 15px 35px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            width: 100%;
            background: rgba(255, 255, 255, 0.15);
            color: white;
            position: relative;
            z-index: 2;
            overflow: hidden;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .footer-section {
            text-align: center;
            padding: 2rem;
            border-top: 1px solid #eee;
            background: #f8f9fa;
        }

        .back-link {
            color: #3ab8ff;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .back-link:hover {
            color: #377D98;
            text-decoration: none;
            transform: translateX(-5px);
        }

        /* Alert Styles */
        .alert {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Modal Enhancements */
        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: linear-gradient(135deg, #3ab8ff, #377D98);
            color: white;
            border-radius: 20px 20px 0 0;
            border-bottom: none;
        }

        .modal-header .btn-close {
            filter: invert(1);
        }

        .modal-body {
            padding: 2rem;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 12px 18px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #3ab8ff;
            box-shadow: 0 0 0 0.2rem rgba(58, 184, 255, 0.15);
        }

        .modal-footer .btn {
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: 600;
        }

        /* Responsive Design */
        @media (max-width: 991.98px) {
            .brand-title {
                font-size: 2.5rem;
            }

            .header-section {
                padding: 2.5rem 1.5rem;
            }

            .options-section {
                padding: 2.5rem 1.5rem;
            }

            .login-option {
                margin: 10px 0;
                padding: 2rem 1.5rem;
            }
        }

        @media (max-width: 767.98px) {
            body {
                padding: 40px 20px;
            }

            .brand-title {
                font-size: 2rem;
            }

            .brand-subtitle {
                font-size: 1.1rem;
            }

            .header-section {
                padding: 2rem 1rem;
            }

            .options-section {
                padding: 2rem 1rem;
            }

            .login-option {
                padding: 1.5rem 1rem;
                margin: 8px 0;
            }

            .option-icon {
                font-size: 3rem;
            }

            .option-title {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 575.98px) {
            body {
                padding: 30px 10px;
            }

            .brand-title {
                font-size: 1.75rem;
            }

            .login-option {
                padding: 1.25rem 0.75rem;
            }

            .btn-custom {
                padding: 12px 25px;
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="login-container">
                    <div class="text-center p-4">
                        <img src="{{ asset('admin/dist/img/logo/handygo.png') }}" alt="HandyGo Logo"
                            style="width:80px; height:80px; object-fit:contain;" class="mb-3">
                        <h1 class="fw-bold mb-2">HandyGo</h1>
                        <p class="text-muted mb-2">Platform Layanan Jasa Harian Terpercaya</p>
                        <p class="text-muted mb-4">Pilih jenis akun Anda untuk masuk ke sistem</p>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        <!-- Customer Login -->
                        <div class="col-lg-4">
                            <div class="login-option customer-option">
                                <i class="fas fa-user fa-3x mb-3"></i>
                                <h4 class="mb-3">Pelanggan</h4>
                                <p class="mb-4">Masuk sebagai pelanggan untuk memesan layanan jasa harian</p>
                                <a href="{{ route('customer.login') }}" class="btn btn-light btn-custom">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login Pelanggan
                                </a>
                            </div>
                        </div>

                        <!-- Provider Login -->
                        <div class="col-lg-4">
                            <div class="login-option provider-option">
                                <i class="fas fa-tools fa-3x mb-3"></i>
                                <h4 class="mb-3">Penyedia Jasa</h4>
                                <p class="mb-4">Masuk sebagai penyedia jasa untuk menerima pesanan</p>
                                <button type="button" class="btn btn-light btn-custom" data-bs-toggle="modal"
                                    data-bs-target="#providerLoginModal">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login Provider
                                </button>
                            </div>
                        </div>

                        <!-- Admin Login -->
                        <div class="col-lg-4">
                            <div class="login-option admin-option">
                                <i class="fas fa-user-shield fa-3x mb-3"></i>
                                <h4 class="mb-3">Administrator</h4>
                                <p class="mb-4">Masuk sebagai admin untuk mengelola sistem</p>
                                <button type="button" class="btn btn-light btn-custom" data-bs-toggle="modal"
                                    data-bs-target="#adminLoginModal">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login Admin
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="text-center p-4">
                        <hr class="my-3">
                        <p class="mb-0">
                            <a href="{{ route('pengguna') }}" class="text-decoration-none">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Provider Login Modal -->
    <div class="modal fade" id="providerLoginModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Login Penyedia Jasa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="provider_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="provider_email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="provider_password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="provider_password" name="password"
                                required>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="provider_remember" name="remember">
                            <label class="form-check-label" for="provider_remember">Ingat saya</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Admin Login Modal -->
    <div class="modal fade" id="adminLoginModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Login Administrator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="admin_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="admin_email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="admin_password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="admin_password" name="password"
                                required>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="admin_remember" name="remember">
                            <label class="form-check-label" for="admin_remember">Ingat saya</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
