<!-- resources/views/layouts/navbar.blade.php -->

<nav class="main-header navbar navbar-expand-lg navbar-orange">
    <!-- Left Navbar Links -->
    <ul class="navbar-nav">
        <!-- Menu Toggle Button -->
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <!-- Toggler Button for Collapsing Navbar Links on Mobile -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent"
        aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
    </button>

    <!-- Search Bar (Display Only) -->
    <form class="form-inline ml-3 d-none d-lg-flex" action="#" method="GET" onsubmit="return false;">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" name="query" placeholder="Search"
                aria-label="Search" readonly>
            <div class="input-group-append">
                <button class="btn btn-navbar" type="button" disabled>
                    <i class="fas fa-search text-orange"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Collapsible Right Navbar Links -->
    <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav ml-auto">
            <!-- Notification Dropdown (Static) -->
            <li class="nav-item dropdown">
                <a class="nav-link text-white position-relative" href="#" id="navbarDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell"></i>
                    <!-- Static Badge for notification count -->
                    <span class="badge badge-danger navbar-badge">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <span class="dropdown-header">3 Notifikasi</span>
                    <div class="dropdown-divider"></div>
                    <!-- Static Notification Items -->
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2 text-primary"></i> Anda menerima pesan baru
                        <span class="float-right text-muted text-sm">3 menit lalu</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2 text-success"></i> 8 teman baru bergabung
                        <span class="float-right text-muted text-sm">12 jam lalu</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2 text-warning"></i> 2 laporan baru tersedia
                        <span class="float-right text-muted text-sm">2 hari lalu</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">Lihat Semua Notifikasi</a>
                </div>
            </li>

            <!-- Navigasi Utama -->
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link text-white font-weight-bold">Home</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('transactions.index') }}" class="nav-link text-white font-weight-bold">Transaksi</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('jobOrders.index') }}" class="nav-link text-white font-weight-bold">History</a>
            </li>

            <!-- Logout -->
            <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link text-white font-weight-bold"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Log out
                </a>
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </ul>
    </div>
</nav>

<!-- Custom Styles -->
<style>
    /* Navbar Custom */
    .navbar-orange {
        background-color: #F36B22;
    }

    .navbar-orange .nav-link {
        color: white;
        font-weight: bold;
    }

    .navbar-orange .nav-link:hover {
        color: #ffe5d0;
    }

    /* Search Bar Styling */
    .form-control-navbar {
        border-radius: 20px;
        background-color: #fff;
        color: #F36B22;
    }

    .form-control-navbar[readonly] {
        background-color: #fff;
        cursor: not-allowed;
    }

    .btn-navbar {
        background-color: white;
        border: none;
        border-radius: 50%;
        padding: 6px 10px;
    }

    .btn-navbar:hover {
        background-color: #ffe5d0;
    }

    /* Dropdown Menu Styling */
    .dropdown-menu {
        min-width: 250px;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    /* Static Badge Styling */
    .navbar-badge {
        position: absolute;
        top: 0.3rem;
        right: 0.3rem;
        font-size: 0.6rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .navbar-nav.ml-auto {
            margin-left: 0;
        }

        .navbar-badge {
            top: 0.5rem;
            right: 1rem;
        }

        /* Adjust positioning for the notification badge on mobile */
        .nav-link.position-relative {
            padding-right: 1.5rem;
        }

        /* Optional: Adjust icon size on mobile */
        .nav-link i {
            font-size: 1.2rem;
        }
    }
</style>
