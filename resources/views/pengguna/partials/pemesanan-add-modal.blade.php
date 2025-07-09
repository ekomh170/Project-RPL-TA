<!-- Add Order Modal -->
<div class="modal fade" id="addOrderModal" tabindex="-1" aria-labelledby="addOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-0 pb-3">
                <div class="modal-title-container">
                    <h4 class="modal-title fw-bold mb-2" id="addOrderModalLabel">
                        <i class="fas fa-credit-card me-3 text-primary"></i>Detail Pembayaran
                    </h4>
                    <p class="text-muted mb-0 fs-6">Lengkapi informasi berikut untuk menyelesaikan pesanan Anda
                    </p>
                </div>
                <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body py-4">

                <form id="newOrderForm" action="{{ route('customer.orders.store') }}" method="POST">
                    @csrf

                    <!-- Service Selection -->
                    <div class="form-section mb-4">
                        <div class="section-header mb-3">
                            <h5 class="section-title">
                                <i class="fas fa-concierge-bell me-2 text-primary"></i>Pilih Layanan
                            </h5>
                        </div>
                        <div class="service-selection">
                            @if (isset($services) && $services->count() > 0)
                                @foreach ($services as $service)
                                    <div class="service-card" data-service-id="{{ $service->id }}"
                                        onclick="selectService({{ $service->id }}, '{{ $service->name }}', {{ $service->price }}, '{{ $service->category }}')">
                                        <div class="service-name">{{ $service->name }}</div>
                                        <div class="service-category">{{ $service->category }}</div>
                                        <div class="service-price">
                                            @if ($service->price > 0)
                                                Rp. {{ number_format($service->price, 0, ',', '.') }}
                                            @else
                                                Harga Sesuai Kesepakatan
                                            @endif
                                        </div>
                                        <div class="has-providers-indicator"
                                            style="display:none; background: #28a745; color: white; padding: 2px 5px; border-radius: 3px; font-size: 10px; margin-top: 5px;">
                                            <i class="fas fa-user-check"></i> Penyedia tersedia
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-info-circle mb-2"></i>
                                    <p>Belum ada layanan tersedia saat ini.</p>
                                </div>
                            @endif
                        </div>
                        <input type="hidden" id="selected_service" name="service_id" required>
                        <div class="invalid-feedback" id="service-error"></div>

                        <div class="text-center mt-3">
                            <button type="button" id="findServicesWithProviders" class="btn btn-outline-success">
                                <i class="fas fa-search me-2"></i>Temukan Layanan Dengan Penyedia
                            </button>
                        </div>
                    </div>

                    <!-- Provider Selection -->
                    <div class="form-section mb-4" id="providerSelectionSection">
                        <div class="section-header mb-3">
                            <h5 class="section-title">
                                <i class="fas fa-user-tie me-2 text-primary"></i>Pilih Penyedia Jasa
                            </h5>
                        </div>
                        <div class="alert alert-info mb-3">
                            <i class="fas fa-info-circle me-2"></i>
                            Pilih penyedia jasa yang akan melakukan layanan Anda. Penyedia jasa akan menyesuaikan dengan
                            layanan yang Anda pilih.
                        </div>

                        <div class="provider-selection">
                            <div class="form-group d-flex gap-2">
                                <select name="provider_id" id="provider_id" class="form-control-modern" required>
                                    <option value="">-- Pilih Penyedia Jasa --</option>
                                    <!-- Provider options will be loaded via JavaScript -->
                                </select>
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="refreshProviders"
                                    title="Muat ulang daftar penyedia jasa">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>

                            <div id="providerWarning" class="alert alert-warning mt-2" style="display: none;">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Perhatian!</strong> Tidak ada penyedia jasa tersedia untuk layanan ini saat ini.
                                Silakan pilih layanan lain atau coba lagi nanti.
                            </div>

                            <div id="providerDetails" class="mt-3" style="display: none;">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="provider-icon">
                                                <i class="fas fa-user-circle fa-3x"></i>
                                            </div>
                                            <div class="provider-info ms-3">
                                                <h5 id="selectedProviderName">Nama Provider</h5>
                                                <div class="provider-rating">
                                                    <span id="selectedProviderRating">0</span>/5
                                                    <i class="fas fa-star text-warning"></i>
                                                    (<span id="selectedProviderReviews">0</span> ulasan)
                                                </div>
                                                <div class="provider-experience" id="selectedProviderExperience">
                                                    Pengalaman: -
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="form-section mb-4">
                        <div class="section-header mb-3">
                            <h5 class="section-title">
                                <i class="fas fa-user me-2 text-primary"></i>Informasi Pelanggan
                            </h5>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-user me-2"></i>Nama Lengkap
                                </label>
                                <input type="text" class="form-control-modern" name="nama_pelanggan"
                                    value="{{ auth()->user()->name ?? 'Andhika' }}" readonly
                                    style="background-color: #f8f9fa; cursor: not-allowed;">
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-phone me-2"></i>Nomor Telepon
                                </label>
                                <input type="tel" class="form-control-modern" name="nomor_telepon"
                                    value="{{ auth()->user()->phone ?? '' }}" placeholder="08xxxxxxxxxx" required>
                                <div class="invalid-feedback" id="nomor_telepon-error"></div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-envelope me-2"></i>Email
                                </label>
                                <input type="email" class="form-control-modern" name="email"
                                    value="{{ auth()->user()->email ?? 'andhika@example.com' }}" readonly
                                    style="background-color: #f8f9fa; cursor: not-allowed;">
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-map-marker-alt me-2"></i>Alamat Lengkap
                                </label>
                                <input type="text" class="form-control-modern" name="alamat"
                                    placeholder="Masukkan alamat lengkap untuk layanan" required>
                                <div class="invalid-feedback" id="alamat-error"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Schedule Service -->
                    <div class="form-section mb-4">
                        <div class="section-header mb-3">
                            <h5 class="section-title">
                                <i class="fas fa-calendar-check me-2 text-primary"></i>Jadwal Layanan
                            </h5>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-calendar-alt me-2"></i>Tanggal
                                </label>
                                <input type="date" class="form-control-modern" name="tanggal_pelaksanaan"
                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                <div class="invalid-feedback" id="tanggal_pelaksanaan-error"></div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-clock me-2"></i>Waktu
                                </label>
                                <select class="form-control-modern" name="waktu_kerja" required>
                                    <option value="">Pilih waktu</option>
                                    <option value="08:00-10:00">08:00 - 10:00</option>
                                    <option value="10:00-12:00">10:00 - 12:00</option>
                                    <option value="13:00-15:00">13:00 - 15:00</option>
                                    <option value="15:00-17:00">15:00 - 17:00</option>
                                    <option value="19:00-21:00">19:00 - 21:00</option>
                                </select>
                                <div class="invalid-feedback" id="waktu_kerja-error"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Special Notes -->
                    <div class="form-section mb-4">
                        <div class="section-header mb-3">
                            <h5 class="section-title">
                                <i class="fas fa-sticky-note me-2 text-primary"></i>Catatan Khusus (Opsional)
                            </h5>
                        </div>

                        <div class="form-group">
                            <textarea class="form-textarea-modern" name="deskripsi" placeholder="Tambahkan catatan atau permintaan khusus"
                                rows="4"></textarea>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="form-section mb-4">
                        <div class="section-header mb-3">
                            <h5 class="section-title">
                                <i class="fas fa-credit-card me-2 text-primary"></i>Metode Pembayaran
                            </h5>
                        </div>

                        <div class="payment-methods">
                            <div class="payment-option" onclick="selectPayment('cash')">
                                <div class="payment-radio">
                                    <input type="radio" name="pembayaran" value="Cash" id="payment-cash"
                                        required>
                                    <label for="payment-cash"></label>
                                </div>
                                <div class="payment-icon">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <div class="payment-info">
                                    <div class="payment-title">Tunai</div>
                                    <div class="payment-desc">Bayar langsung saat layanan</div>
                                </div>
                            </div>

                            <div class="payment-option" onclick="selectPayment('transfer')">
                                <div class="payment-radio">
                                    <input type="radio" name="pembayaran" value="Transfer Bank"
                                        id="payment-transfer" required>
                                    <label for="payment-transfer"></label>
                                </div>
                                <div class="payment-icon">
                                    <i class="fas fa-university"></i>
                                </div>
                                <div class="payment-info">
                                    <div class="payment-title">Transfer Bank</div>
                                    <div class="payment-desc">Transfer ke rekening</div>
                                </div>
                            </div>

                            <div class="payment-option" onclick="selectPayment('ewallet')">
                                <div class="payment-radio">
                                    <input type="radio" name="pembayaran" value="E-Wallet" id="payment-ewallet"
                                        required>
                                    <label for="payment-ewallet"></label>
                                </div>
                                <div class="payment-icon">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                                <div class="payment-info">
                                    <div class="payment-title">E-Wallet</div>
                                    <div class="payment-desc">OVO, DANA, GoPay</div>
                                </div>
                            </div>
                        </div>
                        <div class="invalid-feedback" id="pembayaran-error"></div>
                    </div>

                    <!-- Order Summary -->
                    <div class="form-section mb-4">
                        <div class="section-header mb-3">
                            <h5 class="section-title">
                                <i class="fas fa-receipt me-2 text-primary"></i>Ringkasan Pesanan
                            </h5>
                        </div>

                        <div class="order-summary">
                            <div class="summary-row">
                                <span class="summary-label">Layanan:</span>
                                <span class="summary-value" id="summary-service">Belum dipilih</span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">Biaya Admin:</span>
                                <span class="summary-value" id="summary-admin-fee">Rp. 5.000</span>
                            </div>
                            <div class="summary-divider"></div>
                            <div class="summary-total">
                                <span class="total-label">Total Pembayaran:</span>
                                <span class="total-value" id="summary-total">Rp. 0</span>
                            </div>
                        </div>

                        <div class="security-note">
                            <i class="fas fa-shield-alt me-2"></i>
                            <span>Pembayaran Aman: Transaksi Anda dilindungi dengan enkripsi SSL</span>
                        </div>
                    </div>

                    <!-- Submit Section -->
                    <div class="form-section">
                        <div class="d-grid">
                            <button type="submit" class="btn-submit-order" id="submitBtn">
                                <span class="btn-text">
                                    <i class="fas fa-credit-card me-2"></i>
                                    Konfirmasi & Bayar
                                </span>
                                <span class="btn-loading">
                                    <div class="spinner"></div>
                                    Memproses Pesanan...
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 pt-0 pb-4">
                <div class="d-flex justify-content-between w-100 align-items-center">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batalkan
                    </button>
                    <div class="security-info text-muted small d-flex align-items-center">
                        <i class="fas fa-shield-alt me-2 text-success"></i>
                        <span>Transaksi Aman & Terpercaya</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
