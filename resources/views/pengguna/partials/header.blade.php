<!-- Responsive Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container-fluid">
        <!-- Brand Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ asset('pengguna/assets/img/logo/logohandygo.png') }}" alt="HandyGo"
                style="height: 40px; width: auto;" onerror="this.src='{{ asset('pengguna/doc/img/logo.png') }}'">
            <span class="ms-2 fw-bold text-primary d-none d-md-inline">HandyGo</span>
        </a>

        <!-- Mobile Menu Toggle -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link fw-medium {{ request()->is('/') || request()->is('penggunaHandyGo') ? 'active' : '' }}"
                        href="{{ url('/') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    @auth
                        <a class="nav-link fw-medium {{ request()->routeIs('customer.layanan') ? 'active' : '' }}"
                            href="{{ route('customer.layanan') }}">Layanan</a>
                    @else
                        <a class="nav-link fw-medium {{ request()->is('penggunaHandyGo/layanan') ? 'active' : '' }}"
                            href="{{ url('penggunaHandyGo/layanan') }}">Layanan</a>
                    @endauth
                </li>
                <li class="nav-item">
                    @auth
                        <a class="nav-link fw-medium {{ request()->routeIs('customer.tentangkami') ? 'active' : '' }}"
                            href="{{ route('customer.tentangkami') }}">Tentang Kami</a>
                    @else
                        <a class="nav-link fw-medium {{ request()->is('penggunaHandyGo/tentangkami') ? 'active' : '' }}"
                            href="{{ url('penggunaHandyGo/tentangkami') }}">Tentang Kami</a>
                    @endauth
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link fw-medium {{ request()->routeIs('customer.pemesanan') ? 'active' : '' }}"
                            href="{{ route('customer.pemesanan') }}">Pemesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium {{ request()->routeIs('customer.history') ? 'active' : '' }}"
                            href="{{ route('customer.history') }}">History</a>
                    </li>
                @endauth
            </ul>

            <!-- Auth Buttons -->
            <div class="d-flex flex-column flex-lg-row gap-2">
                @auth
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i>
                            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('customer.profile') }}">
                                    <i class="fas fa-user me-2"></i>Profil
                                </a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('customer.logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">
                        <i class="fas fa-sign-in-alt me-1"></i>Login
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<style>
    /* Custom Navigation Styles */
    .navbar {
        padding: 0.75rem 0;
        transition: all 0.3s ease;
    }

    .navbar-brand img {
        transition: all 0.3s ease;
    }

    .nav-link {
        color: #333 !important;
        font-weight: 500;
        padding: 0.5rem 1rem !important;
        transition: all 0.3s ease;
        position: relative;
    }

    .nav-link:hover {
        color: #3ab8ff !important;
        transform: translateY(-1px);
    }

    .nav-link.active {
        color: #3ab8ff !important;
        font-weight: 600;
    }

    .nav-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background-color: #3ab8ff;
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }

    .nav-link:hover::after,
    .nav-link.active::after {
        width: 80%;
    }

    .navbar-toggler {
        padding: 0.25rem 0.5rem;
        font-size: 1.25rem;
    }

    .navbar-toggler:focus {
        box-shadow: none;
    }

    .dropdown-menu {
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .dropdown-item {
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
    }

    /* Mobile Responsive */
    @media (max-width: 991.98px) {
        .navbar-nav {
            margin: 1rem 0;
        }

        .nav-link {
            padding: 0.75rem 1rem !important;
            border-bottom: 1px solid #eee;
        }

        .nav-link:last-child {
            border-bottom: none;
        }

        .dropdown-menu {
            position: static !important;
            transform: none !important;
            box-shadow: none;
            border: 1px solid #eee;
            margin-top: 0.5rem;
        }
    }
</style>
