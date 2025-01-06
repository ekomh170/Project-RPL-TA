<aside class="main-sidebar elevation-4" style="background-color: #457B9D;">
    <!-- Logo Handy Go -->
    <a href="{{ route('dashboard') }}" class="brand-link text-center" style="background-color: #457B9D;">
        <img src="{{ asset('admin/dist/img/logo/handygo2.png') }}" alt="Logo Handy Go" class="img-fluid"
            style="max-width: 100%; border-radius: 50%; margin-top: -20px; margin-bottom: -40px;">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Panel Pengguna -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <!-- Gambar pengguna -->
            <div class="image">
                <img src="{{ asset('admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <!-- Nama pengguna -->
            <div class="info">
                <a href="{{ route('profile.edit') }}" class="d-block text-white">
                    {{ auth()->user()->name ?? 'Pengguna' }}
                </a>
            </div>
        </div>

        <!-- Menu Sidebar -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Menu Dashboard -->
                @if (auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}"
                            class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                            style="{{ request()->routeIs('dashboard') ? 'background-color: #FFFFFF; color: #457B9D;' : 'color: #FFFFFF;' }}">
                            <i class="nav-icon fas fa-clock"
                                style="{{ request()->routeIs('dashboard') ? 'color: #457B9D;' : 'color: #FFFFFF;' }}"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                @endif


                <!-- Menu untuk Role Penyedia Jasa -->
                @if (auth()->user()->role === 'penyedia_jasa')
                    <!-- Menu Riwayat Pemesanan -->
                    <li class="nav-item">
                        <a href="{{ route('penyediajasa') }}"
                            class="nav-link {{ request()->routeIs('penyediajasa') ? 'active' : '' }}"
                            style="{{ request()->routeIs('penyediajasa') ? 'background-color: #FFFFFF; color: #457B9D;' : 'color: #FFFFFF;' }}">
                            <i class="nav-icon fas fa-clock"
                                style="{{ request()->routeIs('penyediajasa') ? 'color: #457B9D;' : 'color: #FFFFFF;' }}"></i>
                            <p>Penyedia Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('penyediajasa-informasi') }}"
                            class="nav-link {{ request()->routeIs('penyediajasa-informasi') ? 'active' : '' }}"
                            style="{{ request()->routeIs('penyediajasa-informasi') ? 'background-color: #FFFFFF; color: #457B9D;' : 'color: #FFFFFF;' }}">
                            <i class="nav-icon fas fa-list"
                                style="{{ request()->routeIs('penyediajasa-informasi') ? 'color: #457B9D;' : 'color: #FFFFFF;' }}"></i>
                            <p>Informasi Pribadi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('penyediajasa-transaksi') }}"
                            class="nav-link {{ request()->routeIs('penyediajasa-transaksi') ? 'active' : '' }}"
                            style="{{ request()->routeIs('penyediajasa-transaksi') ? 'background-color: #FFFFFF; color: #457B9D;' : 'color: #FFFFFF;' }}">
                            <i class="nav-icon fas fa-list"
                                style="{{ request()->routeIs('penyediajasa-transaksi') ? 'color: #457B9D;' : 'color: #FFFFFF;' }}"></i>
                            <p>Transaksi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('penyediajasa-history') }}"
                            class="nav-link {{ request()->routeIs('penyediajasa-history') ? 'active' : '' }}"
                            style="{{ request()->routeIs('penyediajasa-history') ? 'background-color: #FFFFFF; color: #457B9D;' : 'color: #FFFFFF;' }}">
                            <i class="nav-icon fas fa-list"
                                style="{{ request()->routeIs('penyediajasa-history') ? 'color: #457B9D;' : 'color: #FFFFFF;' }}"></i>
                            <p>History</p>
                        </a>
                    </li>
                @else
                    <!-- Menu Transaksi (Untuk pengguna lain) -->
                    <li class="nav-item">
                        <a href="{{ route('transactions.index') }}"
                            class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}"
                            style="{{ request()->routeIs('transactions.*') ? 'background-color: #FFFFFF; color: #457B9D;' : 'color: #FFFFFF;' }}">
                            <i class="nav-icon fas fa-money-bill-wave"
                                style="{{ request()->routeIs('transactions.*') ? 'color: #457B9D;' : 'color: #FFFFFF;' }}"></i>
                            <p>Transaksi</p>
                        </a>
                    </li>

                    <!-- Menu Data Pengguna (Untuk admin) -->
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}"
                            class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                            style="{{ request()->routeIs('users.*') ? 'background-color: #FFFFFF; color: #457B9D;' : 'color: #FFFFFF;' }}">
                            <i class="nav-icon fas fa-users"
                                style="{{ request()->routeIs('users.*') ? 'color: #457B9D;' : 'color: #FFFFFF;' }}"></i>
                            <p>Data Pengguna</p>
                        </a>
                    </li>

                    <!-- Menu Data Penyedia Jasa (Untuk admin) -->
                    <li class="nav-item">
                        <a href="{{ route('penyediajasa') }}"
                            class="nav-link {{ request()->routeIs('penyediajasa') ? 'active' : '' }}"
                            style="{{ request()->routeIs('penyediajasa') ? 'background-color: #FFFFFF; color: #457B9D;' : 'color: #FFFFFF;' }}">
                            <i class="nav-icon fas fa-users"
                                style="{{ request()->routeIs('penyediajasa') ? 'color: #457B9D;' : 'color: #FFFFFF;' }}"></i>
                            <p>Data Penyedia Jasa</p>
                        </a>
                    </li>

                    <!-- Menu Riwayat Pemesanan -->
                    <li class="nav-item">
                        <a href="{{ route('jobOrders.index') }}"
                            class="nav-link {{ request()->routeIs('jobOrders.*') ? 'active' : '' }}"
                            style="{{ request()->routeIs('jobOrders.*') ? 'background-color: #FFFFFF; color: #457B9D;' : 'color: #FFFFFF;' }}">
                            <i class="nav-icon fas fa-list"
                                style="{{ request()->routeIs('jobOrders.*') ? 'color: #457B9D;' : 'color: #FFFFFF;' }}"></i>
                            <p>Riwayat Pemesanan</p>
                        </a>
                    </li>

                    <!-- Menu Layanan -->
                    <li class="nav-item">
                        <a href="{{ route('services.index') }}"
                            class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}"
                            style="{{ request()->routeIs('services.*') ? 'background-color: #FFFFFF; color: #457B9D;' : 'color: #FFFFFF;' }}">
                            <i class="nav-icon fas fa-concierge-bell"
                                style="{{ request()->routeIs('services.*') ? 'color: #457B9D;' : 'color: #FFFFFF;' }}"></i>
                            <p>Layanan</p>
                        </a>
                    </li>

                    <!-- Menu Notifikasi -->
                    <li class="nav-item">
                        <a href="{{ route('notifications.index') }}"
                            class="nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}"
                            style="{{ request()->routeIs('notifications.*') ? 'background-color: #FFFFFF; color: #457B9D;' : 'color: #FFFFFF;' }}">
                            <i class="nav-icon fas fa-bell"
                                style="{{ request()->routeIs('notifications.*') ? 'color: #457B9D;' : 'color: #FFFFFF;' }}"></i>
                            <p>Notifikasi</p>
                        </a>
                    </li>
                @endif

                <!-- Menu Pengaturan Profil -->
                <li class="nav-item">
                    <a href="{{ route('profile.edit') }}"
                        class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}"
                        style="{{ request()->routeIs('profile.*') ? 'background-color: #FFFFFF; color: #457B9D;' : 'color: #FFFFFF;' }}">
                        <i class="nav-icon fas fa-user-cog"
                            style="{{ request()->routeIs('profile.*') ? 'color: #457B9D;' : 'color: #FFFFFF;' }}"></i>
                        <p>Pengaturan Profil</p>
                    </a>
                </li>

                <!-- Menu Keluar -->
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="confirmLogout(event)"
                        style="color: #FFFFFF; background-color: transparent; transition: background-color 0.3s;">
                        <i class="nav-icon fas fa-sign-out-alt" style="color: #FFFFFF;"></i>
                        <p>Keluar</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<script>
    function confirmLogout(event) {
        event.preventDefault(); // Mencegah form logout dikirim langsung
        if (confirm('Apakah Anda yakin ingin keluar?')) {
            document.getElementById('logout-form').submit(); // Menyubmit form logout jika konfirmasi diterima
        }
    }
</script>

<!-- Form Logout -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
