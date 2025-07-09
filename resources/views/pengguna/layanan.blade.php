@extends('pengguna.layouts.app')

@section('content')
    @push('styles')
        <style>
            /* Page Header */
            .page-header {
                background: linear-gradient(135deg, #3ab8ff 0%, #377D98 100%);
                color: white;
                padding: 80px 0 60px;
                position: relative;
            }

            /* Service Grid */
            .service-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 30px;
                padding: 40px 0;
            }

            .service-card {
                background: white;
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
                transition: all 0.4s ease;
                border: 1px solid #f0f0f0;
                position: relative;
            }

            .service-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            }

            .service-card .image-container {
                position: relative;
                overflow: hidden;
                height: 240px;
            }

            .service-card img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.4s ease;
            }

            .service-card:hover img {
                transform: scale(1.1);
            }

            .service-card .content {
                padding: 25px;
                text-align: center;
            }

            .service-card h3 {
                margin: 0 0 12px;
                font-size: 1.35rem;
                font-weight: 600;
                color: #333;
                line-height: 1.3;
            }

            .service-card .category {
                color: #666;
                font-size: 0.95rem;
                margin-bottom: 15px;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                font-weight: 500;
            }

            .service-card .price {
                font-weight: 700;
                color: #3ab8ff;
                margin-bottom: 20px;
                font-size: 1.2rem;
            }

            .service-card .btn {
                width: 100%;
                max-width: 220px;
                margin: 0 auto;
                display: block;
                border-radius: 25px;
                padding: 12px 25px;
                font-weight: 600;
                transition: all 0.3s ease;
            }

            .service-card .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(58, 184, 255, 0.3);
            }

            /* Category Filter */
            .category-filter {
                background: white;
                padding: 10px 0 30px 0;
                /* Atas didekatkan ke search, bawah tetap rapi */
                border-bottom: 1px solid #eee;
                margin-bottom: 40px;
            }

            .filter-btn {
                background: #f8f9fa;
                border: 2px solid transparent;
                color: #666;
                padding: 10px 20px;
                border-radius: 25px;
                margin: 5px;
                transition: all 0.3s ease;
                font-weight: 500;
            }

            .filter-btn:hover,
            .filter-btn.active {
                background: #3ab8ff;
                color: white;
                border-color: #3ab8ff;
                transform: translateY(-2px);
            }

            /* Empty State */
            .empty-state {
                text-align: center;
                padding: 80px 20px;
                color: #666;
            }

            .empty-state i {
                font-size: 4rem;
                color: #ddd;
                margin-bottom: 20px;
            }

            .empty-state h3 {
                font-size: 1.5rem;
                margin-bottom: 15px;
                color: #333;
            }

            /* Loading State */
            .loading-card {
                background: #f8f9fa;
                border-radius: 20px;
                padding: 40px;
                text-align: center;
            }

            .loading-spinner {
                width: 40px;
                height: 40px;
                border: 4px solid #f3f3f3;
                border-top: 4px solid #3ab8ff;
                border-radius: 50%;
                animation: spin 1s linear infinite;
                margin: 0 auto 20px;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }

            /* Search Bar */
            .search-container {
                background: white;
                padding: 20px 0 10px 0;
                /* Lebih tipis, bawah didekatkan */
                margin-bottom: 0;
                /* Hilangkan jarak bawah */
            }

            .search-box {
                position: relative;
                max-width: 500px;
                margin: 0 auto;
            }

            .search-box input {
                width: 100%;
                padding: 15px 50px 15px 20px;
                border: 2px solid #eee;
                border-radius: 25px;
                font-size: 1rem;
                transition: all 0.3s ease;
            }

            .search-box input:focus {
                outline: none;
                border-color: #3ab8ff;
                box-shadow: 0 0 0 3px rgba(58, 184, 255, 0.1);
            }

            .search-box button {
                position: absolute;
                right: 5px;
                top: 50%;
                transform: translateY(-50%);
                background: #3ab8ff;
                border: none;
                border-radius: 50%;
                width: 40px;
                height: 40px;
                color: white;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .search-box button:hover {
                background: #0056b3;
                transform: translateY(-50%) scale(1.05);
            }

            /* Responsive Design */
            @media (max-width: 767.98px) {
                .page-header {
                    padding: 60px 0 40px;
                }

                .page-header h1 {
                    font-size: 2rem;
                }

                .service-grid {
                    grid-template-columns: 1fr;
                    gap: 20px;
                    padding: 20px 0;
                }

                .service-card .content {
                    padding: 20px;
                }

                .service-card h3 {
                    font-size: 1.2rem;
                }

                .category-filter {
                    padding: 5px 0 20px 0;
                }

                .filter-btn {
                    padding: 8px 16px;
                    font-size: 0.9rem;
                }

                .search-container {
                    padding: 12px 0 5px 0;
                }

                .search-box input {
                    padding: 12px 45px 12px 15px;
                }
            }

            @media (max-width: 575.98px) {
                .service-grid {
                    grid-template-columns: 1fr;
                    gap: 15px;
                }

                .service-card .content {
                    padding: 15px;
                }

                .page-header h1 {
                    font-size: 1.75rem;
                }

                .filter-btn {
                    display: block;
                    width: 100%;
                    margin: 5px 0;
                }
            }
        </style>
    @endpush

    <!-- Page Header -->
    <section class="page-header">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="display-4 fw-bold mb-3">Layanan Kami</h1>
                    <p class="lead">Temukan berbagai layanan profesional untuk kebutuhan harian Anda</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Search Section -->
    <section class="search-container">
        <div class="container-fluid">
            <div class="search-box position-relative">
                <input type="text" id="searchInput" class="form-control pe-5" placeholder="Cari layanan..."
                    autocomplete="off">
                <button type="button" class="btn btn-primary position-absolute"
                    style="top:50%;right:10px;transform:translateY(-50%);border-radius:25px;" onclick="searchServices()">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Category Filter -->
    <section class="category-filter">
        <div class="container-fluid">
            <div class="text-center">
                <div class="filter-buttons d-flex flex-wrap gap-2 justify-content-center mt-2">
                    <button type="button" class="filter-btn active text-uppercase fw-bold" data-category="all"
                        onclick="filterCategory('all', this)"><i class="fas fa-th-large me-1"></i> SEMUA</button>
                    @php
                        $uniqueCategories = $services->pluck('category')->unique()->sort();
                    @endphp
                    @foreach ($uniqueCategories as $cat)
                        <button type="button" class="filter-btn text-uppercase fw-bold"
                            data-category="{{ strtolower($cat) }}"
                            onclick="filterCategory('{{ strtolower($cat) }}', this)"><i class="fas fa-tag me-1"></i>
                            {{ strtoupper($cat) }}</button>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-5">
        <div class="container-fluid">
            <div class="service-grid" id="servicesContainer">
                @forelse($services as $service)
                    @php
                        $serviceImages = [
                            'Jasa Perbaikan Elektronik' => 'pengguna/assets/img/img_Layanan/Orang_berotot.jpg',
                            'Jasa Pemasangan AC' => 'pengguna/assets/img/img_Layanan/ART-Info-DampakAngkat-03.jpg',
                            'Jasa Pengelolaan Media Sosial' =>
                                'pengguna/assets/img/img_Layanan/Screenshot_20240703_100927_Gallery.jpg',
                            'Jasa Desain Grafis' => 'pengguna/assets/img/img_Layanan/556302340423bd98328b4567.jpeg',
                            'Jasa Kebersihan' => 'pengguna/assets/img/img_Layanan/556302340423bd98328b4567.jpeg',
                            'Jasa Fotografi' => 'pengguna/assets/img/img_Layanan/Jokowi_mantau.jpg',
                            'Jasa Renovasi' => 'pengguna/assets/img/img_Layanan/Orang_berotot.jpg',
                            'Jasa Pembuatan Website' =>
                                'pengguna/assets/img/img_Layanan/Screenshot_20240703_100927_Gallery.jpg',
                            'default' => 'pengguna/assets/img/img_Layanan/HandyFood.jpg',
                        ];
                        $image = $serviceImages[$service->name] ?? $serviceImages['default'];
                        $categorySlug = strtolower($service->category);
                    @endphp
                    <div class="service-card" data-category="{{ $categorySlug }}"
                        data-name="{{ strtolower($service->name) }}">
                        <div class="image-container">
                            <img src="{{ asset($image) }}" alt="{{ $service->name }}"
                                onerror="this.src='{{ asset('pengguna/assets/img/img_Layanan/HandyFood.jpg') }}'">
                        </div>
                        <div class="content">
                            <h3>{{ $service->name }}</h3>
                            <p class="category">{{ $service->category }}</p>
                            <p class="price">Mulai dari Rp. {{ number_format($service->price, 0, ',', '.') }}</p>
                            @auth
                                <a href="{{ route('customer.payment') }}" class="btn btn-primary">
                                    <i class="fas fa-shopping-cart me-2"></i>Pesan Sekarang
                                </a>
                            @else
                                <a href="{{ url('penggunaHandyGo/payment') }}" class="btn btn-primary">
                                    <i class="fas fa-shopping-cart me-2"></i>Pesan Sekarang
                                </a>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state">
                            <i class="fas fa-search"></i>
                            <h3>Belum Ada Layanan Tersedia</h3>
                            <p>Layanan sedang dalam pengembangan. Silakan kembali lagi nanti atau hubungi customer service
                                kami untuk informasi lebih lanjut.</p>
                            <a href="https://wa.me/6281316814112" class="btn btn-primary mt-3">
                                <i class="fab fa-whatsapp me-2"></i>Hubungi Customer Service
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- No Results Message -->
            <div id="noResults" class="empty-state" style="display: none;">
                <i class="fas fa-search"></i>
                <h3>Tidak Ada Hasil Ditemukan</h3>
                <p>Coba gunakan kata kunci lain atau pilih kategori yang berbeda.</p>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            // Search functionality
            function searchServices() {
                const searchTerm = document.getElementById('searchInput').value.toLowerCase();
                filterServices(searchTerm);
            }

            // Category filter functionality
            function filterCategory(category, btn) {
                // Update active button
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                if (btn) btn.classList.add('active');

                // Filter services
                const searchTerm = document.getElementById('searchInput').value.toLowerCase();
                filterServices(searchTerm, category);
            }

            function filterServices(searchTerm = '', category = 'all') {
                const serviceCards = document.querySelectorAll('.service-card');
                let visibleCount = 0;

                serviceCards.forEach(card => {
                    const cardCategory = card.dataset.category;
                    const cardName = card.dataset.name;

                    const matchesSearch = searchTerm === '' || cardName.includes(searchTerm);
                    const matchesCategory = category === 'all' || cardCategory === category;

                    if (matchesSearch && matchesCategory) {
                        card.style.display = 'block';
                        visibleCount++;
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, 100);
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Show/hide no results message
                const noResults = document.getElementById('noResults');
                if (visibleCount === 0) {
                    noResults.style.display = 'block';
                } else {
                    noResults.style.display = 'none';
                }
            }

            // Search on input
            document.getElementById('searchInput').addEventListener('input', function() {
                const activeBtn = document.querySelector('.filter-btn.active');
                const category = activeBtn ? activeBtn.getAttribute('data-category') : 'all';
                const searchTerm = this.value.toLowerCase();
                filterServices(searchTerm, category);
            });

            // Enter key search
            document.getElementById('searchInput').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    searchServices();
                }
            });

            // Initial animation
            document.addEventListener('DOMContentLoaded', function() {
                const serviceCards = document.querySelectorAll('.service-card');
                serviceCards.forEach((card, index) => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';

                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, index * 100);
                });

                // Fix: Add event listeners to filter buttons after DOMContentLoaded
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        setTimeout(smoothScrollToTop, 300);
                    });
                });
            });

            // Smooth scroll to top when category changes
            function smoothScrollToTop() {
                window.scrollTo({
                    top: document.querySelector('.search-container').offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        </script>
    @endpush
@endsection
