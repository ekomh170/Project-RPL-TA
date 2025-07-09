<!-- Active Orders Section -->
<section class="py-5">
    <div class="container-fluid">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">Pesanan Aktif</h2>
            <p class="text-muted">Pantau progress pesanan Anda yang sedang berlangsung</p>
        </div>

        @forelse($active_orders as $order)
            <div class="active-order-card">
                <div class="order-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="order-id">Order #{{ $order->id }}</div>
                            <div class="order-date">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                        <div>
                            <span class="status-badge status-{{ strtolower($order->status) }}">
                                <i class="fas fa-clock"></i>
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="order-body">
                    <div class="service-info">
                        @php
                            // Array gambar untuk berbagai jenis service
                            $serviceImages = [
                                'Jasa Perbaikan Elektronik' => 'pengguna/assets/img/img_Layanan/Orang_berotot.jpg',
                                'Jasa Pemasangan AC' => 'pengguna/assets/img/img_Layanan/ART-Info-DampakAngkat-03.jpg',
                                'Jasa Pengelolaan Media Sosial' =>
                                    'pengguna/assets/img/img_Layanan/Screenshot_20240703_100927_Gallery.jpg',
                                'Jasa Desain Grafis' => 'pengguna/assets/img/img_Layanan/556302340423bd98328b4567.jpeg',
                                'Jasa Fotografi' => 'pengguna/assets/img/img_Layanan/Jokowi_mantau.jpg',
                                'default' => 'pengguna/assets/img/img_Layanan/HandyFood.jpg',
                            ];
                            $image =
                                $serviceImages[$order->service ? $order->service->nama_jasa : ''] ??
                                $serviceImages['default'];
                        @endphp
                        <img src="{{ asset($image) }}"
                            alt="{{ $order->service ? $order->service->name ?? ($order->service->nama_jasa ?? 'Service') : 'Service' }}"
                            class="service-image"
                            onerror="this.src='{{ asset('pengguna/assets/img/img_Layanan/HandyFood.jpg') }}'">
                        <div class="service-details">
                            <h5>{{ $order->service ? $order->service->name ?? ($order->service->nama_jasa ?? 'Layanan Tidak Diketahui') : 'Layanan Tidak Diketahui' }}
                            </h5>
                            <div class="provider">
                                <i class="fas fa-user-tie"></i>
                                @if ($order->provider && $order->provider->user)
                                    {{ $order->provider->user->name }}
                                @else
                                    <span class="text-muted">Mencari penyedia jasa...</span>
                                @endif
                            </div>
                            <div class="price">
                                <i class="fas fa-money-bill-wave"></i>
                                {{ $order->getFormattedFinalPrice() }}
                            </div>
                            @if ($order->scheduled_at)
                                <div class="service-date mt-2">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ \Carbon\Carbon::parse($order->scheduled_at)->format('d M Y') }}
                                    @if ($order->scheduled_at)
                                        - {{ \Carbon\Carbon::parse($order->scheduled_at)->format('H:i') }}
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Status Progress -->
                    <div class="status-progress">
                        <div class="progress-container">
                            <!-- Background line -->
                            <div class="progress-line"></div>

                            <!-- Active progress line -->
                            <div class="progress-line-active"
                                data-step="@if ($order->status == 'Pending') 1
                                @elseif($order->status == 'Diproses') 2
                                @elseif($order->status == 'Dikerjakan') 3
                                @else 4 @endif">
                            </div>

                            <!-- Progress steps -->
                            <div class="progress-step {{ $order->status == 'menunggu' ? 'active' : ($order->status == 'diterima' || $order->status == 'dikerjakan' || $order->status == 'selesai' ? 'completed' : '') }}"
                                data-step="1">
                                1
                            </div>
                            <div class="progress-step {{ $order->status == 'diterima' ? 'active' : ($order->status == 'dikerjakan' || $order->status == 'selesai' ? 'completed' : '') }}"
                                data-step="2">
                                2
                            </div>
                            <div class="progress-step {{ $order->status == 'dikerjakan' ? 'active' : ($order->status == 'selesai' ? 'completed' : '') }}"
                                data-step="3">
                                3
                            </div>
                            <div class="progress-step {{ $order->status == 'selesai' ? 'completed' : '' }}"
                                data-step="4">
                                4
                            </div>
                        </div>

                        <div class="progress-labels">
                            <div class="progress-label {{ $order->status == 'Pending' ? 'active' : '' }}">Pending
                            </div>
                            <div class="progress-label {{ $order->status == 'Diproses' ? 'active' : '' }}">Diproses
                            </div>
                            <div class="progress-label {{ $order->status == 'Dikerjakan' ? 'active' : '' }}">
                                Dikerjakan
                            </div>
                            <div class="progress-label {{ $order->status == 'Selesai' ? 'active' : '' }}">Selesai
                            </div>
                        </div>
                    </div>

                    @if ($order->deskripsi)
                        <div class="order-note mb-3">
                            <strong><i class="fas fa-sticky-note me-2"></i>Deskripsi Pekerjaan:</strong>
                            <p class="mt-2">{{ $order->deskripsi }}</p>
                        </div>
                    @endif

                    @if ($order->gender && $order->gender !== 'Tidak Ada Preferensi')
                        <div class="order-preference mb-3">
                            <strong><i class="fas fa-venus-mars me-2"></i>Preferensi Gender:</strong>
                            <span class="ms-2">{{ $order->gender }}</span>
                        </div>
                    @endif

                    @if ($order->pembayaran)
                        <div class="order-payment mb-3">
                            <strong><i class="fas fa-credit-card me-2"></i>Metode Pembayaran:</strong>
                            <span class="ms-2">{{ $order->pembayaran }}</span>
                        </div>
                    @endif

                    <div class="order-actions">
                        @if ($order->status == 'Pending')
                            <button class="btn-action btn-danger-action" onclick="cancelOrder({{ $order->id }})">
                                <i class="fas fa-times"></i>
                                Batalkan
                            </button>
                            <button class="btn-action btn-primary-action" onclick="editOrder({{ $order->id }})">
                                <i class="fas fa-edit"></i>
                                Edit
                            </button>
                        @endif

                        @if ($order->status == 'Diproses' || $order->status == 'Dikerjakan')
                            <button class="btn-action btn-success-action"
                                onclick="contactProvider({{ $order->id }})">
                                <i class="fab fa-whatsapp"></i>
                                Hubungi Penyedia
                            </button>
                        @endif

                        <button class="btn-action btn-primary-action" onclick="viewDetails({{ $order->id }})">
                            <i class="fas fa-eye"></i>
                            Detail Lengkap
                        </button>

                        <button class="btn-action btn-primary-action" onclick="trackOrder({{ $order->id }})">
                            <i class="fas fa-map-marker-alt"></i>
                            Lacak Pesanan
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-shopping-bag"></i>
                <h3>Tidak Ada Pesanan Aktif</h3>
                <p>
                    Anda tidak memiliki pesanan yang sedang berlangsung saat ini.
                    Jelajahi layanan kami dan temukan yang Anda butuhkan!
                </p>
                <a href="{{ route('customer.layanan') }}" class="btn-cta">
                    <i class="fas fa-search me-2"></i>
                    Jelajahi Layanan
                </a>
            </div>
        @endforelse
    </div>
</section>
