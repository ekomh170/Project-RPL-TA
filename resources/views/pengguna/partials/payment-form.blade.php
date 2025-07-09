<div class="payment-page">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="payment-container">
                    <div class="payment-header">
                        <h3>Detail Pembayaran</h3>
                        <p>Lengkapi informasi berikut untuk menyelesaikan pesanan Anda</p>
                    </div>

                    <div class="payment-body">
                        <form id="paymentForm" action="{{ route('customer.payment.store') }}" method="POST">
                            @csrf

                            <!-- Service Selection -->
                            <div class="form-section">
                                <h4 class="section-title">
                                    <i class="fas fa-concierge-bell"></i>
                                    Pilih Layanan
                                </h4>

                                <div class="service-grid">
                                    @forelse($services->take(6) as $index => $service)
                                        <div class="service-option" onclick="selectService({{ $index }})">
                                            <input type="radio" name="service_id" value="{{ $service->id }}"
                                                id="service_{{ $index }}" {{ $index == 0 ? 'checked' : '' }}>
                                            <div class="service-info">
                                                <h5>{{ $service->name }}</h5>
                                                <div class="service-category">{{ $service->category }}</div>
                                                <div class="service-price">Rp.
                                                    {{ number_format($service->price, 0, ',', '.') }}</div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center py-4">
                                            <p class="text-muted">Tidak ada layanan tersedia saat ini.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Customer Information -->
                            <div class="form-section">
                                <h4 class="section-title">
                                    <i class="fas fa-user"></i>
                                    Informasi Pelanggan
                                </h4>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="customer_name" class="form-label">
                                                <i class="fas fa-user me-1"></i>Nama Lengkap
                                            </label>
                                            <div class="input-group">
                                                <i class="input-icon fas fa-user"></i>
                                                <input type="text" class="form-control" id="customer_name"
                                                    name="customer_name" value="{{ Auth::user()->name ?? '' }}"
                                                    placeholder="Masukkan nama lengkap" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="customer_phone" class="form-label">
                                                <i class="fas fa-phone me-1"></i>Nomor Telepon
                                            </label>
                                            <div class="input-group">
                                                <i class="input-icon fas fa-phone"></i>
                                                <input type="tel" class="form-control" id="customer_phone"
                                                    name="customer_phone" placeholder="08xxxxxxxxxx" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="customer_email" class="form-label">
                                        <i class="fas fa-envelope me-1"></i>Email
                                    </label>
                                    <div class="input-group">
                                        <i class="input-icon fas fa-envelope"></i>
                                        <input type="email" class="form-control" id="customer_email"
                                            name="customer_email" value="{{ Auth::user()->email ?? '' }}"
                                            placeholder="nama@email.com" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="customer_address" class="form-label">
                                        <i class="fas fa-map-marker-alt me-1"></i>Alamat Lengkap
                                    </label>
                                    <textarea class="form-control" id="customer_address" name="customer_address" rows="3"
                                        placeholder="Masukkan alamat lengkap untuk layanan" required>{{ isset($user_address) ? $user_address : '' }}</textarea>
                                </div>
                            </div>

                            <!-- Schedule -->
                            <div class="form-section">
                                <h4 class="section-title">
                                    <i class="fas fa-calendar"></i>
                                    Jadwal Layanan
                                </h4>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="service_date" class="form-label">
                                                <i class="fas fa-calendar-day me-1"></i>Tanggal
                                            </label>
                                            <div class="input-group">
                                                <i class="input-icon fas fa-calendar-day"></i>
                                                <input type="date" class="form-control" id="service_date"
                                                    name="service_date" min="{{ date('Y-m-d') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="service_time" class="form-label">
                                                <i class="fas fa-clock me-1"></i>Waktu
                                            </label>
                                            <div class="input-group">
                                                <i class="input-icon fas fa-clock"></i>
                                                <select class="form-control" id="service_time" name="service_time"
                                                    required>
                                                    <option value="">Pilih waktu</option>
                                                    <option value="08:00">08:00 WIB</option>
                                                    <option value="09:00">09:00 WIB</option>
                                                    <option value="10:00">10:00 WIB</option>
                                                    <option value="11:00">11:00 WIB</option>
                                                    <option value="13:00">13:00 WIB</option>
                                                    <option value="14:00">14:00 WIB</option>
                                                    <option value="15:00">15:00 WIB</option>
                                                    <option value="16:00">16:00 WIB</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="special_notes" class="form-label">
                                        <i class="fas fa-sticky-note me-1"></i>Catatan Khusus (Opsional)
                                    </label>
                                    <textarea class="form-control" id="special_notes" name="special_notes" rows="3"
                                        placeholder="Tambahkan catatan atau permintaan khusus"></textarea>
                                </div>

                                <!-- Catatan Bantuan -->
                                <div class="alert alert-info mt-2" style="font-size: 0.95em;">
                                    <i class="fas fa-info-circle me-1"></i>
                                    <strong>Catatan Bantuan:</strong> Pastikan alamat sudah benar dan pilih tanggal
                                    serta jam layanan yang masih tersedia. Jika memilih hari ini, hanya jam yang belum
                                    lewat yang bisa dipilih.
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="form-section">
                                <h4 class="section-title">
                                    <i class="fas fa-credit-card"></i>
                                    Metode Pembayaran
                                </h4>

                                <div class="payment-methods">
                                    <div class="payment-method" onclick="selectPayment('cash')">
                                        <input type="radio" name="payment_method" value="cash" id="cash"
                                            checked>
                                        <div class="payment-icon">
                                            <i class="fas fa-money-bill-wave"></i>
                                        </div>
                                        <div class="payment-name">Tunai</div>
                                        <div class="payment-desc">Bayar langsung saat layanan</div>
                                    </div>

                                    <div class="payment-method" onclick="selectPayment('transfer')">
                                        <input type="radio" name="payment_method" value="transfer" id="transfer">
                                        <div class="payment-icon">
                                            <i class="fas fa-university"></i>
                                        </div>
                                        <div class="payment-name">Transfer Bank</div>
                                        <div class="payment-desc">Transfer ke rekening</div>
                                    </div>

                                    <div class="payment-method" onclick="selectPayment('ewallet')">
                                        <input type="radio" name="payment_method" value="ewallet" id="ewallet">
                                        <div class="payment-icon">
                                            <i class="fas fa-mobile-alt"></i>
                                        </div>
                                        <div class="payment-name">E-Wallet</div>
                                        <div class="payment-desc">OVO, DANA, GoPay</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Summary -->
                            <div class="order-summary">
                                <h5 class="mb-3">
                                    <i class="fas fa-receipt me-2"></i>
                                    Ringkasan Pesanan
                                </h5>

                                <div id="selectedService" class="summary-item">
                                    <span class="summary-label">Layanan:</span>
                                    <span class="summary-value">-</span>
                                </div>

                                <div class="summary-item">
                                    <span class="summary-label">Biaya Admin:</span>
                                    <span class="summary-value">Rp. 5.000</span>
                                </div>

                                <div class="summary-item">
                                    <span class="summary-label">Total Pembayaran:</span>
                                    <span class="summary-value" id="totalAmount">Rp. 0</span>
                                </div>
                            </div>

                            <div class="security-note">
                                <i class="fas fa-shield-alt"></i>
                                <strong>Pembayaran Aman:</strong> Transaksi Anda dilindungi dengan enkripsi SSL
                            </div>

                            <button type="submit" class="btn-submit" id="submitBtn">
                                <i class="fas fa-lock me-2"></i>
                                Konfirmasi & Bayar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
