@guest
    <div class="login-required-alert">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="alert alert-warning login-prompt">
                        <div class="text-center">
                            <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                            <h4 class="alert-heading">Login Diperlukan!</h4>
                            <p class="mb-3">
                                Anda harus login terlebih dahulu untuk menggunakan fitur ini.<br>
                                Silakan login atau daftar untuk melanjutkan.
                            </p>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('customer.login') }}" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-1"></i>Login Sekarang
                                </a>
                                <a href="{{ route('register') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-user-plus me-1"></i>Daftar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .login-required-alert {
            padding: 40px 0;
            background: #f8f9fa;
        }

        .login-prompt {
            background: linear-gradient(135deg, #fff3cd 0%, #fef5e7 100%);
            border: 2px solid #ffeaa7;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            color: #856404;
        }

        .login-prompt .fas.fa-exclamation-triangle {
            color: #f39c12;
        }

        .login-prompt .btn {
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .login-prompt .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .login-prompt .btn-primary {
            background: linear-gradient(135deg, #3ab8ff, #377D98);
            border: none;
        }

        .login-prompt .btn-outline-primary {
            border: 2px solid #3ab8ff;
            color: #3ab8ff;
        }

        .login-prompt .btn-outline-primary:hover {
            background: #3ab8ff;
            color: white;
        }
    </style>
@endguest
