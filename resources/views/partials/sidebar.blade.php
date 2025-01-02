<aside class="main-sidebar elevation-4" style="background-color: #457B9D;">
    <!-- Logo Handy Go -->
    <a href="{{ route('dashboard') }}" class="brand-link text-center" style="background-color: #457B9D;">
        <img src="{{ asset('admin/dist/img/logo/handygo.png') }}" alt="Logo Handy Go" class="img-fluid"
            style="max-width: 100%; border-radius: 50%; margin-top-: -20px; margin-bottom: -40px;">
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
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        style="{{ request()->routeIs('dashboard') ? 'background-color: #FFFFFF; color: #457B9D;' : 'color: #FFFFFF;' }}">
                        <i class="nav-icon fas fa-clock"
                            style="{{ request()->routeIs('dashboard') ? 'color: #457B9D;' : 'color: #FFFFFF;' }}"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Menu Transaksi -->
                <li class="nav-item">
                    <a href="{{ route('transactions.index') }}"
                        class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}"
                        style="{{ request()->routeIs('transactions.*') ? 'background-color: #FFFFFF; color: #457B9D;' : 'color: #FFFFFF;' }}">
                        <i class="nav-icon fas fa-money-bill-wave"
                            style="{{ request()->routeIs('transactions.*') ? 'color: #457B9D;' : 'color: #FFFFFF;' }}"></i>
                        <p>Transaksi</p>
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

                <!-- Menu Data Pengguna -->
                <li class="nav-item">
                    <a href="{{ route('users.index') }}"
                        class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                        style="{{ request()->routeIs('users.*') ? 'background-color: #FFFFFF; color: #457B9D;' : 'color: #FFFFFF;' }}">
                        <i class="nav-icon fas fa-users"
                            style="{{ request()->routeIs('users.*') ? 'color: #457B9D;' : 'color: #FFFFFF;' }}"></i>
                        <p>Data Pengguna</p>
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
                    <a href="{{ route('logout') }}" class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        style="color: #FFFFFF;">
                        <i class="nav-icon fas fa-sign-out-alt" style="color: #FFFFFF;"></i>
                        <p>Logout</p>
                    </a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </ul>
        </nav>
        <!-- /.menu-sidebar -->
    </div>
    <!-- /.sidebar -->
</aside>
