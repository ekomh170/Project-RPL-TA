<!-- Page Header -->
<section class="page-header">
    <div class="container-fluid">
        <div class="text-center">
            <h1 class="fw-bold mb-2">Kelola Pesanan</h1>
            <p class="mb-3">Buat pesanan baru atau pantau pesanan aktif Anda</p>
            @auth
                <button type="button" class="btn-cta" data-bs-toggle="modal" data-bs-target="#addOrderModal">
                    <i class="fas fa-plus-circle me-2"></i>
                    Buat Pesanan Baru
                </button>
            @else
                <button type="button" class="btn-cta" onclick="checkLoginRequired()" style="background: #6c757d;">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Login untuk Buat Pesanan
                </button>
            @endauth
        </div>
    </div>
</section>
