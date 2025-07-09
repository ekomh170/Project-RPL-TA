<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard Customer - HandyGo' }}</title>

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
            background: #f8f9fa;
        }

        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        .sidebar {
            background: white;
            min-height: calc(100vh - 76px);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar .nav-link {
            color: #333;
            padding: 12px 20px;
            border-radius: 8px;
            margin: 5px 15px;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            transform: translateX(5px);
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .bg-primary-gradient {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .bg-success-gradient {
            background: linear-gradient(135deg, #56ab2f, #a8e6cf);
        }

        .bg-warning-gradient {
            background: linear-gradient(135deg, #f093fb, #f5576c);
        }

        .bg-info-gradient {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
        }

        .content-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border: none;
        }

        .order-card {
            border-left: 4px solid #667eea;
            transition: transform 0.3s;
        }

        .order-card:hover {
            transform: translateX(5px);
        }

        .notification-item {
            border-left: 4px solid #28a745;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 10px;
            transition: all 0.3s;
        }

        .notification-item:hover {
            background: #e9ecef;
            transform: translateX(5px);
        }

        .service-card {
            border-radius: 15px;
            transition: transform 0.3s;
        }

        .service-card:hover {
            transform: translateY(-5px);
        }

        .provider-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 25px;
            padding: 8px 20px;
            transition: transform 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
        }

        .badge {
            border-radius: 20px;
            padding: 5px 12px;
        }

        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-hand-holding-heart me-2"></i>HandyGo
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto">
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                            data-bs-toggle="dropdown">
                            <div class="provider-avatar me-2" style="width: 35px; height: 35px; font-size: 0.8rem;">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                            {{ $user->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Pengaturan</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('customer.logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 col-xl-2 p-0">
                <div class="sidebar">
                    <div class="p-3">
                        <h6 class="text-muted text-uppercase fw-bold mb-3">Menu Utama</h6>
                        <nav class="nav flex-column">
                            <a class="nav-link active" href="#dashboard">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                            <a class="nav-link" href="#orders">
                                <i class="fas fa-shopping-cart me-2"></i>Pesanan Saya
                            </a>
                            <a class="nav-link" href="#services">
                                <i class="fas fa-cogs me-2"></i>Layanan
                            </a>
                            <a class="nav-link" href="#history">
                                <i class="fas fa-history me-2"></i>Riwayat
                            </a>
                            <a class="nav-link" href="#notifications">
                                <i class="fas fa-bell me-2"></i>Notifikasi
                                @if ($unread_notifications > 0)
                                    <span class="badge bg-danger ms-2">{{ $unread_notifications }}</span>
                                @endif
                            </a>
                            <a class="nav-link" href="#profile">
                                <i class="fas fa-user me-2"></i>Profil
                            </a>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9 col-xl-10">
                <div class="p-4">
                    <!-- Welcome Section -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="fw-bold mb-1">Selamat Datang, {{ $user->name }}! 👋</h2>
                            <p class="text-muted mb-0">Berikut adalah ringkasan aktivitas akun Anda hari ini.</p>
                        </div>
                        <div class="text-end">
                            <small class="text-muted">{{ \Carbon\Carbon::now()->format('l, d F Y') }}</small>
                        </div>
                    </div>

                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="stat-card">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon bg-primary-gradient me-3">
                                        <i class="fas fa-shopping-cart"></i>
                                    </div>
                                    <div>
                                        <h3 class="fw-bold mb-0">{{ $total_orders }}</h3>
                                        <small class="text-muted">Total Pesanan</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="stat-card">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon bg-success-gradient me-3">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div>
                                        <h3 class="fw-bold mb-0">{{ $completed_orders }}</h3>
                                        <small class="text-muted">Selesai</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="stat-card">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon bg-warning-gradient me-3">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div>
                                        <h3 class="fw-bold mb-0">{{ $pending_orders }}</h3>
                                        <small class="text-muted">Pending</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="stat-card">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon bg-info-gradient me-3">
                                        <i class="fas fa-rupiah-sign"></i>
                                    </div>
                                    <div>
                                        <h3 class="fw-bold mb-0">{{ number_format($total_spent, 0, ',', '.') }}</h3>
                                        <small class="text-muted">Total Pengeluaran</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Recent Orders -->
                        <div class="col-lg-8 mb-4">
                            <div class="content-card">
                                <div class="card-header bg-transparent border-0 pb-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="fw-bold mb-0">Pesanan Terbaru</h5>
                                        <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @forelse($recent_orders as $order)
                                        <div class="order-card p-3 mb-3">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <h6 class="fw-bold mb-1">
                                                        {{ $order->service->nama ?? 'Service Tidak Ditemukan' }}</h6>
                                                    <p class="text-muted mb-2">
                                                        {{ $order->deskripsi_pekerjaan }}
                                                    </p>
                                                    <div class="d-flex align-items-center">
                                                        <small class="text-muted me-3">
                                                            <i class="fas fa-calendar me-1"></i>
                                                            {{ $order->created_at->format('d M Y') }}
                                                        </small>
                                                        <small class="text-muted me-3">
                                                            <i class="fas fa-user me-1"></i>
                                                            {{ $order->penyediaJasa->user->name ?? 'Provider tidak ditemukan' }}
                                                        </small>
                                                        <small class="text-muted">
                                                            <i class="fas fa-rupiah-sign me-1"></i>
                                                            Rp {{ number_format($order->harga, 0, ',', '.') }}
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="ms-3">
                                                    @php
                                                        $badgeClass = match ($order->status) {
                                                            'Pending' => 'bg-warning',
                                                            'Diproses' => 'bg-info',
                                                            'Dikerjakan' => 'bg-primary',
                                                            'Selesai' => 'bg-success',
                                                            'Batal' => 'bg-danger',
                                                            default => 'bg-secondary',
                                                        };
                                                    @endphp
                                                    <span
                                                        class="badge {{ $badgeClass }}">{{ $order->status }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <h6 class="text-muted">Belum ada pesanan</h6>
                                            <p class="text-muted">Mulai pesan layanan untuk melihat riwayat pesanan
                                                Anda</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Notifications -->
                        <div class="col-lg-4 mb-4">
                            <div class="content-card">
                                <div class="card-header bg-transparent border-0 pb-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="fw-bold mb-0">Notifikasi Terbaru</h5>
                                        @if ($unread_notifications > 0)
                                            <span class="badge bg-danger">{{ $unread_notifications }} Baru</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    @forelse($latest_notifications as $notification)
                                        <div
                                            class="notification-item {{ $notification->is_read ? 'opacity-75' : '' }}">
                                            <div class="d-flex align-items-start">
                                                <div class="me-3">
                                                    @php
                                                        $iconClass = match ($notification->notification_type) {
                                                            'job_order' => 'fas fa-shopping-cart text-primary',
                                                            'payment' => 'fas fa-credit-card text-success',
                                                            'status_update' => 'fas fa-info-circle text-info',
                                                            'system' => 'fas fa-cog text-warning',
                                                            'reminder' => 'fas fa-bell text-danger',
                                                            default => 'fas fa-bell text-secondary',
                                                        };
                                                    @endphp
                                                    <i class="{{ $iconClass }}"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p class="mb-1 small">{{ $notification->pesan }}</p>
                                                    <small
                                                        class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-3">
                                            <i class="fas fa-bell-slash fa-2x text-muted mb-2"></i>
                                            <p class="text-muted small">Tidak ada notifikasi</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Available Services -->
                    <div class="row">
                        <div class="col-12">
                            <div class="content-card">
                                <div class="card-header bg-transparent border-0">
                                    <h5 class="fw-bold mb-0">Layanan Tersedia</h5>
                                    <p class="text-muted small mb-0">Pilih layanan yang Anda butuhkan</p>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @forelse($available_services as $service)
                                            <div class="col-lg-4 col-md-6 mb-3">
                                                <div class="service-card card border-0 h-100">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-start mb-3">
                                                            <div class="stat-icon bg-primary-gradient me-3"
                                                                style="width: 50px; height: 50px;">
                                                                <i class="fas fa-cogs"></i>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="fw-bold mb-1">{{ $service->nama }}</h6>
                                                                <small
                                                                    class="text-muted">{{ $service->kategori }}</small>
                                                            </div>
                                                        </div>
                                                        <p class="small text-muted mb-3">
                                                            {{ Str::limit($service->deskripsi, 80) }}</p>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <span class="fw-bold text-primary">
                                                                Rp {{ number_format($service->harga, 0, ',', '.') }}
                                                            </span>
                                                            <button class="btn btn-sm btn-primary">
                                                                <i class="fas fa-plus me-1"></i>Pesan
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12 text-center py-4">
                                                <i class="fas fa-tools fa-3x text-muted mb-3"></i>
                                                <h6 class="text-muted">Tidak ada layanan tersedia</h6>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Auto dismiss alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                if (alert.classList.contains('show')) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            });
        }, 5000);

        // Active nav link highlighting based on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.sidebar .nav-link');

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    navLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>

</html>
