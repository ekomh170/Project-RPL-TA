<!-- Responsive Footer -->
<footer class="bg-primary text-white py-5">
    <div class="container-fluid">
        <!-- Support Section -->
        <div class="row mb-4">
            <div class="col-lg-8 col-md-7">
                <h5 class="fw-bold mb-3">Butuh Bantuan? Hubungi Tim Support Kami</h5>
                <p class="mb-0">Senin - Minggu 06.00 - 22.00 (WIB)</p>
            </div>
            <div class="col-lg-4 col-md-5 text-md-end text-start mt-3 mt-md-0">
                <a href="https://wa.me/6281316814112" 
                   class="btn btn-outline-light rounded-pill px-4">
                    <i class="fab fa-whatsapp me-2"></i>Kontak Kami
                </a>
            </div>
        </div>

        <hr class="my-4 border-light opacity-25">

        <!-- Main Footer Content -->
        <div class="row g-4">
            <!-- Informasi HandyGo -->
            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3">INFORMASI HANDYGO</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ url('/') }}" class="text-white-50 text-decoration-none">
                            <i class="fas fa-home me-2"></i>Beranda
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ url('penggunaHandyGo/layanan') }}" class="text-white-50 text-decoration-none">
                            <i class="fas fa-concierge-bell me-2"></i>Layanan
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ url('penggunaHandyGo/tentangkami') }}" class="text-white-50 text-decoration-none">
                            <i class="fas fa-info-circle me-2"></i>Tentang Kami
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="https://wa.me/6281316814112" class="text-white-50 text-decoration-none">
                            <i class="fas fa-phone me-2"></i>Kontak Kami
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Hubungi Kami -->
            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3">HUBUNGI KAMI</h6>
                <ul class="list-unstyled">
                    <li class="mb-2 d-flex align-items-center">
                        <i class="fas fa-phone text-white-50 me-3"></i>
                        <span class="text-white-50">08131681412</span>
                    </li>
                    <li class="mb-2 d-flex align-items-start">
                        <i class="fas fa-map-marker-alt text-white-50 me-3 mt-1"></i>
                        <span class="text-white-50">STT TERPADU NURUL FIKRI</span>
                    </li>
                    <li class="mb-2 d-flex align-items-center">
                        <i class="fas fa-envelope text-white-50 me-3"></i>
                        <span class="text-white-50">handygo@gmail.com</span>
                    </li>
                </ul>
            </div>

            <!-- Disclaimer & Social -->
            <div class="col-lg-6 col-md-12">
                <h6 class="fw-bold mb-3">TENTANG LAYANAN</h6>
                <p class="text-white-50 mb-3">
                    Handy Go tidak bertanggung jawab atas transaksi langsung yang dilakukan 
                    pelanggan dengan mitra (tidak melalui admin). Pastikan selalu menggunakan 
                    platform resmi untuk keamanan transaksi Anda.
                </p>
                
                <!-- Social Media -->
                <div class="d-flex gap-3">
                    <a href="#" class="text-white-50 fs-4" title="Website">
                        <i class="fas fa-globe"></i>
                    </a>
                    <a href="#" class="text-white-50 fs-4" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-white-50 fs-4" title="Facebook">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" class="text-white-50 fs-4" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
            </div>
        </div>

        <hr class="my-4 border-light opacity-25">

        <!-- Copyright -->
        <div class="row">
            <div class="col-12 text-center">
                <p class="text-white-50 mb-0">
                    &copy; {{ date('Y') }} HandyGo. All rights reserved. 
                    <span class="d-block d-md-inline">Made with <i class="fas fa-heart text-danger"></i> for better service.</span>
                </p>
            </div>
        </div>
    </div>
</footer>

<style>
    .bg-primary {
        background-color: #377D98 !important;
    }
    
    footer a:hover {
        color: #3ab8ff !important;
        transform: translateX(3px);
        transition: all 0.3s ease;
    }
    
    footer .social-links a:hover {
        transform: translateY(-3px);
        color: #3ab8ff !important;
    }
    
    /* Mobile Responsive */
    @media (max-width: 767.98px) {
        footer h6 {
            font-size: 1rem;
        }
        
        footer p,
        footer li {
            font-size: 0.9rem;
        }
        
        .btn-outline-light {
            font-size: 0.9rem;
            padding: 0.5rem 1rem !important;
        }
    }
</style>
