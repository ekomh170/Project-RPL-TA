@extends('pengguna.layouts.app')

@section('content')
    @push('styles')
        <style>
            /* Profile Header */
            .profile-header {
                background: linear-gradient(135deg, #3ab8ff 0%, #377D98 100%);
                color: white;
                padding: 60px 0;
                position: relative;
            }

            .profile-card {
                background: white;
                border-radius: 20px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                margin-top: -50px;
                position: relative;
                z-index: 10;
                overflow: hidden;
            }

            .profile-avatar {
                width: 120px;
                height: 120px;
                border-radius: 50%;
                border: 5px solid white;
                background: linear-gradient(135deg, #3ab8ff, #377D98);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 3rem;
                color: white;
                margin: 0 auto;
                margin-top: -60px;
            }

            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 20px;
                margin: 30px 0;
            }

            .stat-item {
                text-align: center;
                padding: 25px;
                background: #f8f9fa;
                border-radius: 15px;
                transition: all 0.3s ease;
            }

            .stat-item:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            }

            .stat-number {
                font-size: 2.5rem;
                font-weight: 700;
                color: #3ab8ff;
                display: block;
                margin-bottom: 10px;
            }

            .stat-label {
                color: #666;
                font-weight: 500;
            }

            /* Form Styles */
            .form-section {
                background: white;
                border-radius: 15px;
                padding: 30px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                margin-bottom: 30px;
            }

            .form-group {
                margin-bottom: 25px;
            }

            .form-label {
                font-weight: 600;
                color: #333;
                margin-bottom: 8px;
                display: block;
            }

            .form-control {
                border: 2px solid #eee;
                border-radius: 10px;
                padding: 12px 15px;
                font-size: 1rem;
                transition: all 0.3s ease;
                width: 100%;
            }

            .form-control:focus {
                outline: none;
                border-color: #3ab8ff;
                box-shadow: 0 0 0 3px rgba(58, 184, 255, 0.1);
            }

            .btn-update {
                background: linear-gradient(135deg, #3ab8ff, #377D98);
                border: none;
                color: white;
                padding: 12px 30px;
                border-radius: 25px;
                font-weight: 600;
                transition: all 0.3s ease;
            }

            .btn-update:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(58, 184, 255, 0.3);
                color: white;
            }

            /* Activity Timeline */
            .activity-timeline {
                position: relative;
                padding-left: 30px;
            }

            .activity-timeline::before {
                content: '';
                position: absolute;
                left: 15px;
                top: 0;
                bottom: 0;
                width: 2px;
                background: #eee;
            }

            .activity-item {
                position: relative;
                margin-bottom: 25px;
                background: white;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            }

            .activity-item::before {
                content: '';
                position: absolute;
                left: -37px;
                top: 25px;
                width: 12px;
                height: 12px;
                background: #3ab8ff;
                border-radius: 50%;
                border: 3px solid white;
            }

            /* Responsive Design */
            @media (max-width: 767.98px) {
                .profile-header {
                    padding: 40px 0;
                }

                .profile-avatar {
                    width: 100px;
                    height: 100px;
                    font-size: 2.5rem;
                    margin-top: -50px;
                }

                .stats-grid {
                    grid-template-columns: 1fr 1fr;
                    gap: 15px;
                }

                .stat-item {
                    padding: 20px 15px;
                }

                .stat-number {
                    font-size: 2rem;
                }

                .form-section {
                    padding: 20px;
                    margin-bottom: 20px;
                }

                .activity-timeline {
                    padding-left: 20px;
                }

                .activity-item::before {
                    left: -27px;
                }
            }

            @media (max-width: 575.98px) {
                .stats-grid {
                    grid-template-columns: 1fr;
                }

                .profile-card {
                    margin: -30px 15px 0;
                }

                .form-section {
                    padding: 15px;
                }
            }
        </style>
    @endpush

    <!-- Profile Header -->
    <section class="profile-header">
        <div class="container-fluid">
            <div class="text-center">
                <h1 class="fw-bold mb-2">Profil Saya</h1>
                <p class="mb-0">Kelola informasi personal dan preferensi akun Anda</p>
            </div>
        </div>
    </section>

    <!-- Profile Content -->
    <div class="container-fluid py-5">
        <!-- Profile Card -->
        <div class="profile-card">
            <div class="text-center p-4 pb-0">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <h3 class="mt-3 mb-1">{{ $user->name }}</h3>
                <p class="text-muted">Member sejak {{ $member_since }}</p>
            </div>

            <!-- Stats -->
            <div class="stats-grid p-4">
                <div class="stat-item">
                    <span class="stat-number">{{ $total_orders }}</span>
                    <div class="stat-label">Total Pesanan</div>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $completed_orders }}</span>
                    <div class="stat-label">Pesanan Selesai</div>
                </div>
                <div class="stat-item">
                    <span
                        class="stat-number">{{ $total_orders > 0 ? round(($completed_orders / $total_orders) * 100) : 0 }}%</span>
                    <div class="stat-label">Tingkat Kepuasan</div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <!-- Update Profile Form -->
            <div class="col-lg-8">
                <div class="form-section">
                    <h4 class="mb-4">
                        <i class="fas fa-edit text-primary me-2"></i>
                        Update Informasi Profil
                    </h4>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('customer.profile.update') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">
                                        <i class="fas fa-user me-1"></i>Nama Lengkap
                                    </label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name', $user->name) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-1"></i>Email
                                    </label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email', $user->email) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-lock me-1"></i>Password Baru
                                    </label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Kosongkan jika tidak ingin mengubah password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label">
                                        <i class="fas fa-lock me-1"></i>Konfirmasi Password
                                    </label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" placeholder="Konfirmasi password baru">
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-update">
                                <i class="fas fa-save me-2"></i>Update Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Account Info -->
            <div class="col-lg-4">
                <div class="form-section">
                    <h5 class="mb-4">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Informasi Akun
                    </h5>

                    <div class="info-item mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar text-muted me-3"></i>
                            <div>
                                <small class="text-muted">Bergabung sejak</small>
                                <div>{{ $user->created_at->format('d M Y') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="info-item mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-shield-alt text-success me-3"></i>
                            <div>
                                <small class="text-muted">Status Akun</small>
                                <div class="text-success">Terverifikasi</div>
                            </div>
                        </div>
                    </div>

                    <div class="info-item mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-star text-warning me-3"></i>
                            <div>
                                <small class="text-muted">Level Member</small>
                                <div>
                                    @if ($total_orders >= 10)
                                        <span class="badge bg-warning">Gold Member</span>
                                    @elseif($total_orders >= 5)
                                        <span class="badge bg-secondary">Silver Member</span>
                                    @else
                                        <span class="badge bg-primary">Bronze Member</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="form-section">
                    <h5 class="mb-4">
                        <i class="fas fa-bolt text-primary me-2"></i>
                        Aksi Cepat
                    </h5>

                    <div class="d-grid gap-2">
                        <a href="{{ route('customer.layanan') }}" class="btn btn-outline-primary">
                            <i class="fas fa-search me-2"></i>Cari Layanan
                        </a>
                        <a href="{{ route('customer.history') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-history me-2"></i>Lihat Riwayat
                        </a>
                        <a href="{{ route('customer.pemesanan') }}" class="btn btn-outline-info">
                            <i class="fas fa-shopping-bag me-2"></i>Pesanan Aktif
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Form validation
            document.querySelector('form').addEventListener('submit', function(e) {
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('password_confirmation').value;

                if (password && password !== confirmPassword) {
                    e.preventDefault();
                    alert('Konfirmasi password tidak cocok!');
                    return false;
                }

                if (password && password.length < 6) {
                    e.preventDefault();
                    alert('Password minimal 6 karakter!');
                    return false;
                }
            });

            // Auto dismiss alerts
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    if (alert.classList.contains('show')) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                });
            }, 5000);

            // Animate stats on page load
            document.addEventListener('DOMContentLoaded', function() {
                const statNumbers = document.querySelectorAll('.stat-number');

                statNumbers.forEach(stat => {
                    const finalValue = parseInt(stat.textContent);
                    stat.textContent = '0';

                    let currentValue = 0;
                    const increment = finalValue / 50;

                    const counter = setInterval(() => {
                        currentValue += increment;
                        if (currentValue >= finalValue) {
                            stat.textContent = finalValue + (stat.textContent.includes('%') ? '%' : '');
                            clearInterval(counter);
                        } else {
                            stat.textContent = Math.floor(currentValue) + (stat.textContent.includes(
                                '%') ? '%' : '');
                        }
                    }, 30);
                });
            });
        </script>
    @endpush

@endsection
