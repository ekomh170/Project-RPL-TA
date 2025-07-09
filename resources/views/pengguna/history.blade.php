@extends('pengguna.layouts.app')

@section('content')
    @push('styles')
        <style>
            /* Page Header */
            .page-header {
                background: linear-gradient(135deg, #3ab8ff 0%, #377D98 100%);
                color: white;
                padding: 60px 0;
                position: relative;
            }

            /* Order Card */
            .order-card {
                background: white;
                border-radius: 15px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                margin-bottom: 20px;
                overflow: hidden;
                transition: all 0.3s ease;
                border: 1px solid #f0f0f0;
            }

            .order-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            }

            .order-header {
                background: #f8f9fa;
                padding: 15px 20px;
                border-bottom: 1px solid #eee;
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 10px;
            }

            .order-id {
                font-weight: 600;
                color: #333;
                font-size: 0.95rem;
            }

            .order-date {
                color: #666;
                font-size: 0.9rem;
            }

            .order-body {
                padding: 20px;
            }

            .service-info {
                display: flex;
                align-items: start;
                gap: 15px;
                margin-bottom: 20px;
            }

            .service-image {
                width: 80px;
                height: 80px;
                border-radius: 10px;
                object-fit: cover;
                flex-shrink: 0;
            }

            .service-details h5 {
                margin: 0 0 5px;
                font-weight: 600;
                color: #333;
                font-size: 1.1rem;
            }

            .service-details .provider {
                color: #666;
                font-size: 0.9rem;
                margin-bottom: 5px;
            }

            .service-details .price {
                color: #3ab8ff;
                font-weight: 600;
                font-size: 1rem;
            }

            /* Status Badge */
            .status-badge {
                padding: 8px 16px;
                border-radius: 20px;
                font-size: 0.85rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .status-pending {
                background: #fff3cd;
                color: #856404;
                border: 1px solid #ffeaa7;
            }

            .status-diproses {
                background: #d4edda;
                color: #155724;
                border: 1px solid #c3e6cb;
            }

            .status-dikerjakan {
                background: #cce5ff;
                color: #004085;
                border: 1px solid #99d1ff;
            }

            .status-selesai {
                background: #d1ecf1;
                color: #0c5460;
                border: 1px solid #bee5eb;
            }

            .status-dibatalkan {
                background: #f8d7da;
                color: #721c24;
                border: 1px solid #f5c6cb;
            }

            /* Order Actions */
            .order-actions {
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
                margin-top: 15px;
            }

            .btn-action {
                padding: 8px 16px;
                border-radius: 20px;
                border: none;
                font-size: 0.85rem;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.3s ease;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 5px;
            }

            .btn-primary-action {
                background: #3ab8ff;
                color: white;
            }

            .btn-primary-action:hover {
                background: #0056b3;
                color: white;
                transform: translateY(-1px);
            }

            .btn-secondary-action {
                background: #6c757d;
                color: white;
            }

            .btn-secondary-action:hover {
                background: #545b62;
                color: white;
                transform: translateY(-1px);
            }

            .btn-success-action {
                background: #28a745;
                color: white;
            }

            .btn-success-action:hover {
                background: #1e7e34;
                color: white;
                transform: translateY(-1px);
            }

            /* Filter Section */
            .filter-section {
                background: white;
                padding: 25px;
                border-radius: 15px;
                margin-bottom: 30px;
                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
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
                cursor: pointer;
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

            .empty-state p {
                margin-bottom: 25px;
                line-height: 1.6;
            }

            /* Responsive Design */
            @media (max-width: 767.98px) {
                .page-header {
                    padding: 40px 0;
                }

                .order-header {
                    padding: 12px 15px;
                    flex-direction: column;
                    align-items: start;
                }

                .order-body {
                    padding: 15px;
                }

                .service-info {
                    flex-direction: column;
                    gap: 10px;
                }

                .service-image {
                    width: 100%;
                    height: 150px;
                    align-self: center;
                }

                .order-actions {
                    justify-content: center;
                }

                .filter-section {
                    padding: 20px 15px;
                }

                .filter-btn {
                    display: block;
                    width: 100%;
                    margin: 5px 0;
                    text-align: center;
                }
            }

            @media (max-width: 575.98px) {
                .order-card {
                    margin: 0 -15px 20px;
                    border-radius: 0;
                }

                .filter-section {
                    margin: 0 -15px 30px;
                    border-radius: 0;
                }

                .btn-action {
                    flex: 1;
                    justify-content: center;
                }
            }
        </style>
    @endpush

    <!-- Page Header -->
    <section class="page-header">
        <div class="container-fluid">
            <div class="text-center">
                <h1 class="fw-bold mb-2">Riwayat Pesanan</h1>
                <p class="mb-0">Lihat semua pesanan yang pernah Anda buat</p>
            </div>
        </div>
    </section>

    <div class="container-fluid py-5">
        <!-- Filter Section -->
        <div class="filter-section">
            <h5 class="mb-3">Filter berdasarkan status:</h5>
            <div class="filter-buttons">
                <button class="filter-btn active" onclick="filterOrders('all', event)">Semua</button>
                <button class="filter-btn" onclick="filterOrders('menunggu', event)">Menunggu</button>
                <button class="filter-btn" onclick="filterOrders('diterima', event)">Diterima</button>
                <button class="filter-btn" onclick="filterOrders('dikerjakan', event)">Dikerjakan</button>
                <button class="filter-btn" onclick="filterOrders('selesai', event)">Selesai</button>
                <button class="filter-btn" onclick="filterOrders('dibatalkan', event)">Dibatalkan</button>
            </div>
        </div>

        <!-- Orders List -->
        <div class="orders-container">
            @forelse($orders as $order)
                <div class="order-card" data-status="{{ $order->status }}">
                    <div class="order-header">
                        <div>
                            <div class="order-id">Order #{{ $order->id }}</div>
                            <div class="order-date">{{ $order->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        <div>
                            <span class="status-badge status-{{ strtolower($order->status) }}">
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>

                    <div class="order-body">
                        <div class="service-info">
                            @php
                                // Array gambar untuk berbagai jenis service
                                $serviceImages = [
                                    'Jasa Perbaikan Elektronik' => 'pengguna/assets/img/img_Layanan/Orang_berotot.jpg',
                                    'Jasa Pemasangan AC' =>
                                        'pengguna/assets/img/img_Layanan/ART-Info-DampakAngkat-03.jpg',
                                    'Jasa Pengelolaan Media Sosial' =>
                                        'pengguna/assets/img/img_Layanan/Screenshot_20240703_100927_Gallery.jpg',
                                    'Jasa Desain Grafis' =>
                                        'pengguna/assets/img/img_Layanan/556302340423bd98328b4567.jpeg',
                                    'Jasa Fotografi' => 'pengguna/assets/img/img_Layanan/Jokowi_mantau.jpg',
                                    'default' => 'pengguna/assets/img/img_Layanan/HandyFood.jpg',
                                ];
                                $serviceName = $order->service->name ?? ($order->service->nama_jasa ?? '');
                                $image = $serviceImages[$serviceName] ?? $serviceImages['default'];
                            @endphp
                            <img src="{{ asset($image) }}" alt="{{ $serviceName ?: 'Service' }}" class="service-image"
                                onerror="this.src='{{ asset('pengguna/assets/img/img_Layanan/HandyFood.jpg') }}'">

                            <div class="service-details">
                                <h5>{{ $serviceName ?: 'Layanan Tidak Diketahui' }}</h5>
                                <div class="provider">
                                    <i class="fas fa-user me-1"></i>
                                    {{ $order->provider && $order->provider->user ? $order->provider->user->name : 'Penyedia Tidak Diketahui' }}
                                </div>
                                <div class="price">
                                    <i class="fas fa-money-bill-wave me-1"></i>
                                    {{ $order->getFormattedFinalPrice() }}
                                </div>
                            </div>
                        </div>

                        @if ($order->catatan)
                            <div class="order-note mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-sticky-note me-1"></i>
                                    Catatan: {{ $order->catatan }}
                                </small>
                            </div>
                        @endif

                        <div class="order-actions">
                            @if ($order->status == 'Pending')
                                <button class="btn-action btn-secondary-action" onclick="cancelOrder({{ $order->id }})">
                                    <i class="fas fa-times"></i>
                                    Batalkan
                                </button>
                            @endif

                            @if ($order->status == 'Selesai')
                                <button class="btn-action btn-success-action" onclick="rateOrder({{ $order->id }})">
                                    <i class="fas fa-star"></i>
                                    Beri Rating
                                </button>
                                <button class="btn-action btn-primary-action" onclick="reorder({{ $order->id }})">
                                    <i class="fas fa-redo"></i>
                                    Pesan Lagi
                                </button>
                            @endif

                            <button class="btn-action btn-primary-action" onclick="viewDetails({{ $order->id }})">
                                <i class="fas fa-eye"></i>
                                Detail
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-clipboard-list"></i>
                    <h3>Belum Ada Riwayat Pesanan</h3>
                    <p>
                        Anda belum pernah melakukan pemesanan.
                        Jelajahi layanan kami dan temukan yang Anda butuhkan!
                    </p>
                    <a href="{{ route('customer.layanan') }}" class="btn btn-primary btn-lg rounded-pill">
                        <i class="fas fa-search me-2"></i>
                        Jelajahi Layanan
                    </a>
                </div>
            @endforelse
        </div>

        <!-- No Results Message -->
        <div id="noResults" class="empty-state" style="display: none;">
            <i class="fas fa-search"></i>
            <h3>Tidak Ada Pesanan Ditemukan</h3>
            <p>Tidak ada pesanan dengan status yang dipilih.</p>
        </div>
    </div>

    @push('scripts')
        <script>
            // Filter orders by status
            function filterOrders(status, event = null) {
                // Update active button
                document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
                if (event) event.target.classList.add('active');

                const orderCards = document.querySelectorAll('.order-card');
                let visibleCount = 0;

                orderCards.forEach(card => {
                    const cardStatus = card.dataset.status;
                    if (status === 'all' || cardStatus === status) {
                        card.style.display = 'block';
                        visibleCount++;
                        // Animation
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
                const ordersContainer = document.querySelector('.orders-container');

                if (visibleCount === 0 && orderCards.length > 0) {
                    noResults.style.display = 'block';
                    ordersContainer.style.display = 'none';
                } else {
                    noResults.style.display = 'none';
                    ordersContainer.style.display = 'block';
                }
            }

            // Cancel order
            function cancelOrder(orderId) {
                if (confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')) {
                    // Here you would make an AJAX call to cancel the order
                    alert('Fitur pembatalan pesanan akan segera tersedia.');
                    // Example:
                    // fetch('/api/orders/' + orderId + '/cancel', { method: 'POST' })
                    //     .then(response => response.json())
                    //     .then(data => {
                    //         if (data.success) {
                    //             location.reload();
                    //         }
                    //     });
                }
            }

            // Rate order
            function rateOrder(orderId) {
                alert('Fitur rating akan segera tersedia. Terima kasih atas kepercayaan Anda!');
                // Here you would open a rating modal or redirect to rating page
            }

            // Reorder
            function reorder(orderId) {
                if (confirm('Apakah Anda ingin memesan layanan yang sama lagi?')) {
                    alert('Fitur pemesanan ulang akan segera tersedia.');
                    // Here you would handle reordering logic
                }
            }

            // View order details
            function viewDetails(orderId) {
                alert('Detail pesanan #' + orderId + '\n\nFitur detail pesanan akan segera tersedia.');
                // Here you would redirect to order details page or open modal
            }

            // Initial animation
            document.addEventListener('DOMContentLoaded', function() {
                const orderCards = document.querySelectorAll('.order-card');
                orderCards.forEach((card, index) => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';

                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, index * 100);
                });
            });

            // Add smooth scrolling when filter changes
            function smoothScrollToTop() {
                window.scrollTo({
                    top: document.querySelector('.filter-section').offsetTop - 100,
                    behavior: 'smooth'
                });
            }

            // Add smooth scroll to filter buttons
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    setTimeout(smoothScrollToTop, 300);
                });
            });
        </script>
    @endpush
@endsection
