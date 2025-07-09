@extends('pengguna.layouts.app')

@section('content')
    @push('styles')
        <style>
            /* Hero Section */
            .hero-section {
                background: linear-gradient(135deg, #3ab8ff 0%, #377D98 100%);
                color: white;
                padding: 120px 0;
                position: relative;
                overflow: hidden;
                background-attachment: fixed;
                background-repeat: no-repeat;
            }

            .hero-section::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(58, 184, 255, 0.1);
                z-index: 1;
            }

            .hero-content {
                position: relative;
                z-index: 2;
            }

            /* About Section Cards */
            .card {
                transition: all 0.3s ease;
            }

            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
            }

            /* Service Grid */
            .service-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 25px;
                padding: 40px 0;
            }

            .service-card {
                background: white;
                border-radius: 15px;
                overflow: hidden;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
                border: 1px solid #f0f0f0;
            }

            .service-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            }

            .service-card img {
                width: 100%;
                height: 220px;
                object-fit: cover;
                transition: transform 0.3s ease;
            }

            .service-card:hover img {
                transform: scale(1.05);
            }

            .service-card .content {
                padding: 20px;
                text-align: center;
            }

            .service-card h3 {
                margin: 0 0 10px;
                font-size: 1.25rem;
                font-weight: 600;
                color: #333;
            }

            .service-card .category {
                color: #666;
                font-size: 0.9rem;
                margin-bottom: 15px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .service-card .price {
                font-weight: 700;
                color: #3ab8ff;
                margin-bottom: 20px;
                font-size: 1.1rem;
            }

            .service-card .btn {
                width: 100%;
                max-width: 200px;
                margin: 0 auto;
                display: block;
            }

            /* Features Section */
            .features-section {
                background: #f8f9fa;
                padding: 80px 0;
            }

            .feature-card {
                text-align: center;
                padding: 30px 20px;
                background: white;
                border-radius: 15px;
                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
                height: 100%;
            }

            .feature-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            }

            .feature-icon {
                width: 80px;
                height: 80px;
                background: linear-gradient(135deg, #3ab8ff, #377D98);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 20px;
                font-size: 2rem;
                color: white;
                transition: all 0.3s ease;
            }

            .feature-icon:hover {
                transform: scale(1.1);
                box-shadow: 0 5px 15px rgba(58, 184, 255, 0.3);
            }

            /* Stats Section */
            .stats-section {
                background: linear-gradient(135deg, #377D98 0%, #3ab8ff 100%);
                color: white;
                padding: 60px 0;
            }

            .stat-item {
                text-align: center;
                padding: 20px;
            }

            .stat-number {
                font-size: 3rem;
                font-weight: 700;
                margin-bottom: 10px;
                display: block;
            }

            .stat-label {
                font-size: 1.1rem;
                opacity: 0.9;
            }

            /* Responsive Design */
            @media (max-width: 767.98px) {
                .hero-section {
                    padding: 60px 0;
                }

                .hero-section h1 {
                    font-size: 2rem;
                }

                .service-grid {
                    grid-template-columns: 1fr;
                    gap: 20px;
                    padding: 20px 0;
                }

                .features-section {
                    padding: 60px 0;
                }

                .feature-card {
                    margin-bottom: 20px;
                }

                .stats-section {
                    padding: 40px 0;
                }

                .stat-number {
                    font-size: 2.5rem;
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

                .hero-section h1 {
                    font-size: 1.75rem;
                }

                .hero-section p {
                    font-size: 1rem;
                }
            }
        </style>
    @endpush

    <!-- Hero Section -->
    <section class="hero-section"
        style="background-image: linear-gradient(rgba(58, 184, 255, 0.8), rgba(55, 125, 152, 0.8)), url('{{ asset('pengguna/assets/img/gallery/lp.jpg') }}'); background-size: cover; background-position: center;">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 text-center hero-content">
                    <h1 class="display-4 fw-bold mb-4">
                        Solusi Jasa Harian Terpercaya
                    </h1>
                    <p class="lead mb-4">
                        Platform terdepan untuk berbagai kebutuhan jasa harian Anda.
                        Cepat, mudah, dan terpercaya dengan layanan profesional.
                    </p>
                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                        @auth
                            <a href="{{ route('customer.layanan') }}" class="btn btn-light btn-lg rounded-pill px-4">
                                <i class="fas fa-search me-2"></i>Jelajahi Layanan
                            </a>
                        @else
                            <a href="{{ route('public.layanan') }}" class="btn btn-light btn-lg rounded-pill px-4">
                                <i class="fas fa-search me-2"></i>Jelajahi Layanan
                            </a>
                        @endauth
                        <a href="{{ route('customer.login') }}" class="btn btn-outline-light btn-lg rounded-pill px-4">
                            <i class="fas fa-user-plus me-2"></i>Bergabung Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section with Images from Old Version -->
    <section class="py-5 bg-light">
        <div class="container-fluid">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6">
                    <div class="pe-lg-4">
                        <h2 class="fw-bold mb-4">Kenapa Memilih HandyGo?</h2>
                        <p class="lead text-muted mb-4">
                            Dengan HandyGo, Anda bisa menemukan semua layanan terbaik di satu tempat.
                            Kami menghadirkan solusi praktis untuk berbagai kebutuhan harian Anda.
                        </p>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary text-white p-3 me-3">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Cepat & Fleksibel</h6>
                                        <small class="text-muted">Sesuai jadwal Anda</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-success text-white p-3 me-3">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Harga Terjangkau</h6>
                                        <small class="text-muted">Kualitas terbaik</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="{{ asset('pengguna/assets/img/gallery/perempuan.jpg') }}" alt="HandyGo Services"
                        class="img-fluid rounded shadow-lg" style="max-width: 400px;">
                </div>
            </div>

            <!-- Gallery Images Row -->
            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="{{ asset('pengguna/assets/img/gallery/gambar.jpg') }}" alt="Layanan Profesional"
                            class="card-img-top" style="height: 250px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title">Layanan Profesional</h5>
                            <p class="card-text text-muted">Tim ahli berpengalaman siap melayani Anda</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="{{ asset('pengguna/assets/img/gallery/gambar.jpg') }}" alt="Kualitas Terjamin"
                            class="card-img-top" style="height: 250px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title">Kualitas Terjamin</h5>
                            <p class="card-text text-muted">Standar tinggi dalam setiap layanan yang kami berikan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container-fluid">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Apa yang Membuat Kami Berbeda?</h2>
                <p class="text-muted">Keunggulan layanan kami</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h5 class="fw-bold mb-3">1. Cepat dan Fleksibel</h5>
                        <p class="text-muted">Pilih waktu dan layanan sesuai kebutuhan Anda.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <h5 class="fw-bold mb-3">2. Layanan Terjangkau</h5>
                        <p class="text-muted">Kualitas terbaik dengan harga yang masuk akal.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h5 class="fw-bold mb-3">3. Tim Berpengalaman</h5>
                        <p class="text-muted">Pekerja profesional dan terpercaya di bidangnya.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h5 class="fw-bold mb-3">4. Kualitas Terjamin</h5>
                        <p class="text-muted">Standar tinggi dalam setiap layanan yang diberikan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Services Section -->
    <section class="py-5">
        <div class="container-fluid">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Layanan Terpopuler</h2>
                <p class="text-muted">Pilihan favorit pelanggan kami</p>
            </div>

            <div class="service-grid">
                @forelse($services->take(6) as $service)
                    @php
                        $serviceImages = [
                            'Jasa Perbaikan Elektronik' => 'pengguna/assets/img/img_Layanan/Orang_berotot.jpg',
                            'Jasa Pemasangan AC' => 'pengguna/assets/img/img_Layanan/ART-Info-DampakAngkat-03.jpg',
                            'Jasa Pengelolaan Media Sosial' =>
                                'pengguna/assets/img/img_Layanan/Screenshot_20240703_100927_Gallery.jpg',
                            'Jasa Desain Grafis' => 'pengguna/assets/img/img_Layanan/556302340423bd98328b4567.jpeg',
                            'Jasa Fotografi' => 'pengguna/assets/img/img_Layanan/Jokowi_mantau.jpg',
                            'Jasa Cleaning Service' => 'pengguna/assets/img/gallery/perempuan.jpg',
                            'Jasa Perawatan' => 'pengguna/assets/img/gallery/gambar.jpg',
                            'default' => 'pengguna/assets/img/img_Layanan/HandyFood.jpg',
                        ];
                        $image = $serviceImages[$service->name] ?? $serviceImages['default'];
                    @endphp
                    <div class="service-card">
                        <img src="{{ asset($image) }}" alt="{{ $service->name }}"
                            onerror="this.src='{{ asset('pengguna/assets/img/img_Layanan/HandyFood.jpg') }}'">
                        <div class="content">
                            <h3>{{ $service->name }}</h3>
                            <p class="category">{{ $service->category }}</p>
                            <p class="price">Mulai dari Rp. {{ number_format($service->price, 0, ',', '.') }}</p>
                            @auth
                                <a href="{{ route('customer.payment') }}" class="btn btn-primary rounded-pill">
                                    <i class="fas fa-shopping-cart me-2"></i>Pilih Jasa
                                </a>
                            @else
                                <a href="{{ route('public.payment') }}" class="btn btn-primary rounded-pill">
                                    <i class="fas fa-shopping-cart me-2"></i>Pilih Jasa
                                </a>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Belum Ada Layanan Tersedia</strong>
                            <p class="mb-0 mt-2">Layanan sedang dalam pengembangan. Silakan kembali lagi nanti.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if ($services->count() > 6)
                <div class="text-center mt-4">
                    @auth
                        <a href="{{ route('customer.layanan') }}" class="btn btn-outline-primary btn-lg rounded-pill">
                            <i class="fas fa-th-large me-2"></i>Lihat Semua Layanan
                        </a>
                    @else
                        <a href="{{ route('public.layanan') }}" class="btn btn-outline-primary btn-lg rounded-pill">
                            <i class="fas fa-th-large me-2"></i>Lihat Semua Layanan
                        </a>
                    @endauth
                </div>
            @endif
        </div>
    </section>

    @push('scripts')
        <script>
            // Smooth scrolling
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });

            // Animation on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe service cards
            document.querySelectorAll('.service-card, .feature-card').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });
        </script>
    @endpush
@endsection
