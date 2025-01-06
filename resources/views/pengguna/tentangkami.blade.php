<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Handy Go - Tentang Kami</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Helper Function -->
    @php
        $assetFunction = app()->environment('local') ? 'asset' : 'secure_asset';
    @endphp

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ $assetFunction('pengguna/assets') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ $assetFunction('pengguna/assets') }}/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ $assetFunction('pengguna/assets') }}/css/slicknav.css">
    <link rel="stylesheet" href="{{ $assetFunction('pengguna/assets') }}/css/flaticon.css">
    <link rel="stylesheet" href="{{ $assetFunction('pengguna/assets') }}/css/progressbar_barfiller.css">
    <link rel="stylesheet" href="{{ $assetFunction('pengguna/assets') }}/css/gijgo.css">
    <link rel="stylesheet" href="{{ $assetFunction('pengguna/assets') }}/css/animate.min.css">
    <link rel="stylesheet" href="{{ $assetFunction('pengguna/assets') }}/css/animated-headline.css">
    <link rel="stylesheet" href="{{ $assetFunction('pengguna/assets') }}/css/magnific-popup.css">
    <link rel="stylesheet" href="{{ $assetFunction('pengguna/assets') }}/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="{{ $assetFunction('pengguna/assets') }}/css/themify-icons.css">
    <link rel="stylesheet" href="{{ $assetFunction('pengguna/assets') }}/css/slick.css">
    <link rel="stylesheet" href="{{ $assetFunction('pengguna/assets') }}/css/nice-select.css">
    <link rel="stylesheet" href="{{ $assetFunction('pengguna/assets') }}/css/style.css">

</head>

<body class="full-wrapper">
    <!-- ? Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="{{ $assetFunction('pengguna/assets') }}/img/logo/loder.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start-->
    <header>
        <div style="background: #fff; padding: 10px 20px; border-bottom: 1px solid #ddd;">
            <div
                style="display: flex; align-items: center; justify-content: space-between; max-width: 1200px; margin: 0 auto;">
                <!-- Left Section: Logo -->
                <div>
                    <a href="#home">
                        <img src="{{ $assetFunction('pengguna/assets') }}/img/logo/logohandygo.png" alt="Logo"
                            style="height: 100px;">
                    </a>
                </div>

                <!-- Right Section: Navigation Links, Button, and Profile -->
                <div style="display: flex; align-items: center;">
                    <!-- Navigation Links -->
                    <nav>
                        <ul style="list-style: none; margin: 0; padding: 0; display: flex;">
                            <li style="margin-right: 20px;">
                                <a href="{{ url('penggunaHandyGo') }}"
                                    style="text-decoration: none; color: #333; font-size: 16px;">Beranda</a>
                            </li>

                            <li style="margin-right: 20px;">
                                <a href="{{ url('penggunaHandyGo/layanan') }}"
                                    style="text-decoration: none; color: #333; font-size: 16px;">Layanan</a>
                            </li>

                            <li style="margin-right: 20px;">
                                <a href="{{ url('penggunaHandyGo/tentangkami') }}"
                                    style="text-decoration: none; color: #333; font-size: 16px;">Tentang Kami</a>
                            </li>
                        </ul>
                    </nav>

                    @if (Route::has('login'))
                        @auth
                            <!-- Profile -->
                            <div
                                style="margin-left: 20px; display: flex; align-items: center; border: 1px solid #ddd; padding: 5px 10px; border-radius: 20px;">
                                <img src="{{ $assetFunction('pengguna/assets') }}/img/logo/user.jpg" alt="Profile"
                                    style="width: 30px; height: 30px; border-radius: 50%; margin-right: 10px;">
                                <a href="{{ url('penggunaHandyGo/profile') }}"
                                    style="text-decoration: none; font-size: 16px; color: #333;">{{ Auth::user()->name }}</a>
                            </div>

                            <!-- Logout Button -->
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit"
                                    style="text-decoration: none; background: #dc3545; color: #fff; padding: 8px 16px; border-radius: 20px; font-size: 16px; display: inline-flex; align-items: center; margin-left: 20px;">
                                    Logout
                                </button>
                            </form>
                        @else
                            <!-- Button Login -->
                            <a href="{{ route('login') }}"
                                style="text-decoration: none; background: #007bff; color: #fff; padding: 8px 16px; border-radius: 20px; font-size: 16px; display: inline-flex; align-items: center; margin-left: 20px;">
                                Login
                            </a>

                            <!-- Button Registrasi -->
                            <a href="{{ route('register') }}"
                                style="text-decoration: none; background: #007bff; color: #fff; padding: 8px 16px; border-radius: 20px; font-size: 16px; display: inline-flex; align-items: center; margin-left: 20px;">
                                Registrasi
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </header>
    <!-- header end -->
    <main>
        <!-- breadcrumb Start-->

        <!-- breadcrumb End-->
        <!-- About Area Start -->
        <section class="py-5 text-center bg-light">
            <div class="container">
                <h1 class="display-4">About HandyGo</h1>
                <p class="lead">Terkadang, kita bisa memprediksi gerakan benda besar, tetapi kekuatan sebenarnya ada
                    pada hal-hal kecil yang sering terabaikan. HandyGo hadir untuk menangani tugas-tugas kecil dengan
                    dampak besar, memastikan kebutuhan harianmu terpenuhi dengan cepat dan mudah.</p>
            </div>
        </section>

        <!-- Meet Our Team Section -->
        <section id="team" class="py-5 bg-light">
            <div class="container text-center">
                <h2 class="mb-5">Meet Our Team</h2>
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <img src="https://via.placeholder.com/200" class="card-img-top" alt="Team Member">
                            <div class="card-body">
                                <h4 class="card-title">Eko Muchamad Haryono</h4>
                                <p class="card-text">Scrum Master</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <img src="https://via.placeholder.com/200" class="card-img-top" alt="Team Member">
                            <div class="card-body">
                                <h4 class="card-title">Muhammad Andhika Thata</h4>
                                <p class="card-text">Product Owner</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <img src="https://via.placeholder.com/200" class="card-img-top" alt="Team Member">
                            <div class="card-body">
                                <h4 class="card-title">Muhamad Sayyid Fadhil</h4>
                                <p class="card-text">Developer</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <img src="https://via.placeholder.com/200" class="card-img-top" alt="Team Member">
                            <div class="card-body">
                                <h4 class="card-title">Fairuz Shofyah Mumtaz</h4>
                                <p class="card-text">Developer</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <img src="https://via.placeholder.com/200" class="card-img-top" alt="Team Member">
                            <div class="card-body">
                                <h4 class="card-title">Najwa Nur Salimah</h4>
                                <p class="card-text">Developer</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <img src="https://via.placeholder.com/200" class="card-img-top" alt="Team Member">
                            <div class="card-body">
                                <h4 class="card-title">Aria Dillah</h4>
                                <p class="card-text">Developer</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <img src="https://via.placeholder.com/200" class="card-img-top" alt="Team Member">
                            <div class="card-body">
                                <h4 class="card-title">Muhammad Zen Alby</h4>
                                <p class="card-text">Medkre</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <img src="https://via.placeholder.com/200" class="card-img-top" alt="Team Member">
                            <div class="card-body">
                                <h4 class="card-title">Nurhayati</h4>
                                <p class="card-text">Medkre</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Kebijakan Layanan Section -->
        <section class="py-5">
            <div class="container">
                <h2>Kebijakan Layanan</h2>
                <p>HandyGo tidak bertanggung jawab atas transaksi langsung antara Pelanggan dan Mitra yang tidak melalui
                    konfirmasi Admin.</p>
                <p>HandyGo tidak bertanggung jawab atas kerusakan barang setelah pengiriman, terutama jika barang
                    tersebut tidak dapat diperiksa kondisinya sebelum dikirim.</p>
                <p>Pelanggan wajib memberikan konfirmasi kepada Admin setelah layanan selesai, atau menyelesaikan status
                    order di website. Handy Go tidak bertanggung jawab atas kondisi atau permintaan revisi setelah
                    Pelanggan memberikan konfirmasi penyelesaian.</p>
                <p>Layanan Handy Go tersedia dari Senin hingga Minggu, termasuk hari libur nasional, jika ada Mitra yang
                    bersedia dan mampu mengerjakan layanan.</p>
                <p>Pesanan yang dibuat setelah pukul 22.00 WIB akan diproses keesokan harinya.</p>
            </div>
        </section>

        <!-- Biaya Layanan Section -->
        <section class="py-5 bg-light">
            <div class="container">
                <h2>Biaya Layanan</h2>
                <p>Informasi mengenai biaya layanan kami dapat disesuaikan berdasarkan jenis tugas dan kebutuhan
                    pelanggan. Hubungi kami untuk mendapatkan penawaran harga terbaik.</p>
                <p>Biaya layanan bervariasi tergantung pada jenis layanan, lingkup kerja, tingkat kesulitan, dan lokasi.
                </p>
                <p>Handy Go juga menawarkan berbagai paket yang dapat disesuaikan dengan kebutuhan. Silakan hubungi kami
                    untuk informasi lebih lanjut.</p>
            </div>
        </section>

        <!-- Metode Pembelajaran Section -->
        <section class="py-5">
            <div class="container">
                <h2>Metode Pembelajaran</h2>
                <p>Kami memastikan bahwa seluruh mitra HandyGo telah melalui pelatihan profesional untuk menjamin
                    kualitas layanan yang terbaik bagi pelanggan kami.</p>
                <p>Handy Go juga menawarkan berbagai paket yang dapat disesuaikan dengan kebutuhan. Silakan hubungi kami
                    untuk informasi lebih lanjut.</p>
            </div>
        </section>

        <!-- Kebijakan Privasi Section -->
        <section class="py-5 bg-light">
            <div class="container">
                <h2>Kebijakan Privasi</h2>
                <p>HandyGo menjaga kerahasiaan data pribadi pelanggan dan mitra kami sesuai dengan peraturan yang
                    berlaku. Data Anda hanya digunakan untuk keperluan operasional dan tidak akan dibagikan kepada pihak
                    ketiga tanpa izin.</p>
            </div>
        </section>
        <!-- About Area End -->

    </main>

    <footer style="background-color: #377D98; color: white; padding: 20px 50px; font-family: 'Calibri', sans-serif;">
        <div style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 30px;">
            <!-- Section 1: Support Info -->
            <div style="flex: 1; min-width: 200px;">
                <h4 style="font-size: 18px; margin-bottom: 10px; font-weight: bold; color: white;">Butuh Bantuan?
                    Hubungi Tim Support Kami</h4>
                <p style="margin: 0 0 15px; font-size: 14px; color: white;">Senin - Minggu 06.00 - 22.00 (WIB)</p>
            </div>
            <!-- Kontak Kami Button -->
            <div style="min-width: 150px; text-align: right;">
                <a href="https://wa.me/6281316814112"
                    style="background-color: #47A6CE; border: none; padding: 10px 20px; color: white; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block;">
                    Kontak Kami
                </a>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 30px; margin-top: 20px;">
            <!-- Section 2: Informasi HandyGo -->
            <div style="flex: 1; min-width: 200px;">
                <h4 style="font-size: 18px; margin-bottom: 10px; font-weight: bold; color: white;">INFORMASI HANDYGO
                </h4>
                <ul style="list-style: none; padding: 0; margin: 0; line-height: 2;">
                    <li style="font-size: 14px; color: white;">Beranda</li>
                    <li style="font-size: 14px; color: white;">Layanan</li>
                    <li style="font-size: 14px; color: white;">Tentang Kami</li>
                    <li style="font-size: 14px; color: white;">Kontak Kami</li>
                </ul>
            </div>

            <!-- Section 3: Hubungi Kami -->
            <div style="flex: 1; min-width: 200px;">
                <h4 style="font-size: 18px; margin-bottom: 10px; font-weight: bold; color: white;">HUBUNGI KAMI</h4>
                <ul style="list-style: none; padding: 0; margin: 0; line-height: 2;">
                    <li style="font-size: 14px; color: white;">📞 08131681412</li>
                    <li style="font-size: 14px; color: white;">📍 STT TERPADU NURUL FIKRI</li>
                    <li style="font-size: 14px; color: white;">✉️ handygo@gmail.com</li>
                </ul>
            </div>

            <!-- Section 4: Disclaimer -->
            <div style="flex: 2; min-width: 250px;">
                <p style="font-size: 14px; line-height: 1.8; margin: 0; color: white;">Handy Go tidak bertanggung jawab
                    atas transaksi langsung yang dilakukan pelanggan dengan mitra (tidak melalui admin).</p>
                <div style="display: flex; gap: 10px; margin-top: 10px;">
                    <a href="#" style="font-size: 20px; color: white; text-decoration: none;">🌐</a>
                    <a href="#" style="font-size: 20px; color: white; text-decoration: none;">📸</a>
                </div>
            </div>
        </div>

        <!-- Bottom Section -->
        <div style="text-align: center; margin-top: 20px; font-size: 14px; color: #D1D9E0;">
            Made With Love By Capybara All Right Reserved
        </div>
    </footer>
    <!--? Search model Begin -->
    <div class="search-model-box">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-btn">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Searching key.....">
            </form>
        </div>
    </div>
    <!-- Search model end -->
    <!-- Scroll Up -->
    <div id="back-top">
        <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
    </div>

    <!-- JS here -->
    <!-- Jquery, Popper, Bootstrap -->
    <script src="{{ $assetFunction('pengguna/assets') }}/js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="{{ $assetFunction('pengguna/assets') }}/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="{{ $assetFunction('pengguna/assets') }}/js/popper.min.js"></script>
    <script src="{{ $assetFunction('pengguna/assets') }}/js/bootstrap.min.js"></script>

    <!-- Slick-slider , Owl-Carousel ,slick-nav -->
    <script src="{{ $assetFunction('pengguna/assets') }}/js/owl.carousel.min.js"></script>
    <script src="{{ $assetFunction('pengguna/assets') }}/js/slick.min.js"></script>
    <script src="{{ $assetFunction('pengguna/assets') }}/js/jquery.slicknav.min.js"></script>

    <!-- One Page, Animated-HeadLin, Date Picker -->
    <script src="{{ $assetFunction('pengguna/assets') }}/js/wow.min.js"></script>
    <script src="{{ $assetFunction('pengguna/assets') }}/js/animated.headline.js"></script>
    <script src="{{ $assetFunction('pengguna/assets') }}/js/jquery.magnific-popup.js"></script>
    <script src="{{ $assetFunction('pengguna/assets') }}/js/gijgo.min.js"></script>

    <!-- Nice-select, sticky,Progress -->
    <script src="{{ $assetFunction('pengguna/assets') }}/js/jquery.nice-select.min.js"></script>
    <script src="{{ $assetFunction('pengguna/assets') }}/js/jquery.sticky.js"></script>
    <script src="{{ $assetFunction('pengguna/assets') }}/js/jquery.barfiller.js"></script>

    <!-- counter , waypoint,Hover Direction -->
    <script src="{{ $assetFunction('pengguna/assets') }}/js/jquery.counterup.min.js"></script>
    <script src="{{ $assetFunction('pengguna/assets') }}/js/waypoints.min.js"></script>
    <script src="{{ $assetFunction('pengguna/assets') }}/js/jquery.countdown.min.js"></script>
    <script src="{{ $assetFunction('pengguna/assets') }}/js/hover-direction-snake.min.js"></script>

    <!-- contact js -->
    <script src="{{ $assetFunction('pengguna/assets') }}/js/contact.js"></script>
    <script src="{{ $assetFunction('pengguna/assets') }}/js/jquery.form.js"></script>
    <script src="{{ $assetFunction('pengguna/assets') }}/js/jquery.validate.min.js"></script>
    <script src="{{ $assetFunction('pengguna/assets') }}/js/mail-script.js"></script>
    <script src="{{ $assetFunction('pengguna/assets') }}/js/jquery.ajaxchimp.min.js"></script>

    <!-- Jquery Plugins, main Jquery -->
    <script src="{{ $assetFunction('pengguna/assets') }}/js/plugins.js"></script>
    <script src="{{ $assetFunction('pengguna/assets') }}/js/main.js"></script>

</body>

</html>
