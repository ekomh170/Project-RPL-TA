<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Handy Go - Beranda</title>
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
    <style>
        /* Global styling */
        .container-fluid {
            padding: 0;
            margin: 0;
            width: 100%;
        }

        body,
        html {
            overflow-x: hidden;
        }


        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 36px;
            /* Ukuran diperbesar */
            font-weight: bold;
            /* Membuat teks tebal */
            color: #333;
        }

        /* Grid Layout for Services */
        .service-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px 0;
        }

        .service-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .service-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .service-card .content {
            padding: 15px;
            text-align: center;
        }

        .service-card h3 {
            margin: 0 0 10px;
            font-size: 18px;
            font-weight: bold;
        }

        .service-card p {
            margin: 0 0 15px;
            color: #666;
        }

        .service-card .price {
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .service-card button {
            background-color: #3ab8ff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 15px;
            cursor: pointer;
            width: 250px;
            margin: 0 auto;
            display: block;
        }

        .service-card button:hover {
            background-color: #0056b3;
        }
    </style>




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
                                <a href="profile.html"
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
        <!--? Hero Area Start-->
        <div class="container-fluid" style="padding: 0; margin: 0;">
            <div class="slider-area">
                <div class="header-right2 d-flex align-items-center"></div>
                <div class="slider-active dot-style">
                    <div class="single-slider hero-overly d-flex align-items-center"
                        style="position: relative; height: 100vh;">
                        <!-- Image -->
                        <img src="{{ $assetFunction('pengguna/assets') }}/img/gallery/lp.jpg" alt="Background Image"
                            style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; z-index: -1;">

                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-xl-8 col-lg-9 text-center">
                                    <!-- Hero Caption -->
                                    <div class="hero__caption" style="color: #fff;">
                                        <h1 style="font-size: 4rem; font-weight: bold; line-height: 1.2;">
                                            Solusi Praktis <br> untuk Semua Kebutuhan Anda
                                        </h1>
                                        <p style="margin-top: 15px; font-size: 1.75rem; color: #fff;">
                                            Temukan kemudahan berbagai layanan mulai dari kebersihan hingga jasa
                                            lainnya,
                                            semuanya dalam satu platform.
                                        </p>
                                        <a href="{{ url('penggunaHandyGo/layanan') }}" class="btn"
                                            style="margin-top: 25px; background-color: #1e90ff; color: #fff; padding: 20px 40px; font-size: 1.5rem; border-radius: 5px; text-decoration: none;">
                                            Pesan Sekarang
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- End Hero -->
        <!--? New Arrival Start -->

        <!-- Section: Kenapa Harus Handy Go -->
        <div style="display: flex; align-items: center; padding: 60px 30px;">
            <!-- Text Section -->
            <div style="flex: 1; padding-right: 30px;">
                <h1
                    style="font-size: 3.5rem; color: #222; margin-bottom: 30px; font-family: 'Calibri', sans-serif; font-weight: bold;">
                    Kenapa Harus Handy Go?</h1>
                <p style="font-size: 1.6rem; color: #555; line-height: 1.8;">
                    Kami memahami bahwa kebutuhan Anda harus diselesaikan dengan cepat, nyaman, dan efisien.
                    Dengan Handy Go, Anda bisa menemukan semua layanan terbaik di satu tempat.
                </p>
            </div>

            <!-- Image Section -->
            <div style="flex: 1; text-align: center;">
                <img src="{{ $assetFunction('pengguna/assets') }}/img/gallery/perempuan.jpg"
                    alt="Cleaning Illustration" style="max-width: 100%; height: auto; width: 400px;">
            </div>
        </div>

        <!--? New Arrival End -->
        <!--? Services Area Start -->
        <div class="categories-area section-padding40 gray-bg">
            <div class="container-fluid">
                <!-- Judul -->
                <div style="text-align: center; margin-bottom: 50px;">
                    <h2 style="font-size: 3rem; color: #222; font-family: 'Calibri', sans-serif; font-weight: bold;">
                        Apa yang Membuat Kami Berbeda?</h2>
                </div>

                <!-- Dua Gambar Kiri dan Kanan -->
                <div class="row" style="margin-bottom: 50px; text-align: center;">
                    <div class="col-lg-6 col-md-12">
                        <img src="{{ $assetFunction('pengguna/assets') }}/img/gallery/gambar.jpg" alt="Gambar Kiri"
                            style="width: 90%; height: auto; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <img src="{{ $assetFunction('pengguna/assets') }}/img/gallery/gambar.jpg" alt="Gambar Kanan"
                            style="width: 90%; height: auto; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    </div>
                </div>

                <!-- Konten -->
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="single-cat mb-50 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
                            <div class="cat-icon">
                                <img src="{{ $assetFunction('pengguna/assets') }}/img/icon/services1.svg"
                                    alt="">
                            </div>
                            <div class="cat-cap">
                                <h5>1. Cepat dan Fleksibel</h5>
                                <p>Pilih waktu dan layanan sesuai kebutuhan Anda.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="single-cat mb-50 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
                            <div class="cat-icon">
                                <img src="{{ $assetFunction('pengguna/assets') }}/img/icon/services2.svg"
                                    alt="">
                            </div>
                            <div class="cat-cap">
                                <h5>2. Layanan Terjangkau</h5>
                                <p>Kualitas terbaik dengan harga yang masuk akal.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="single-cat mb-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".4s">
                            <div class="cat-icon">
                                <img src="{{ $assetFunction('pengguna/assets') }}/img/icon/services3.svg"
                                    alt="">
                            </div>
                            <div class="cat-cap">
                                <h5>3. Dukungan Profesional</h5>
                                <p>Kami bekerja dengan tim terpercaya dan berpengalaman.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="single-cat wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">
                            <div class="cat-icon">
                                <img src="{{ $assetFunction('pengguna/assets') }}/img/icon/services4.svg"
                                    alt="">
                            </div>
                            <div class="cat-cap">
                                <h5>4. Mudah Digunakan</h5>
                                <p>Antarmuka yang simpel dan ramah pengguna.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h1>Yang Terpopuler</h1>
        <div>
            <div class="service-grid">
                <div class="service-card">
                    <img src="{{ $assetFunction('pengguna/assets') }}/img/img_Layanan/Orang_berotot.jpg"
                        alt="Handy Food">
                    <div class="content">
                        <h3>Nemenin Olahraga</h3>
                        <p>Nemenin kamu olahraga menjadi lebih seru</p>
                        <p class="price">Mulai dari Rp. 130.000</p>
                        <a href="{{ url('penggunaHandyGo/payment') }}">
                            <button>Pilih Jasa</button>
                        </a>
                    </div>
                </div>
                <div class="service-card">
                    <img src="{{ $assetFunction('pengguna/assets') }}/img/img_Layanan/HandyFood.jpg"
                        alt="Handy Food">
                    <div class="content">
                        <h3>Handy Food</h3>
                        <p>Bantu kamu beliin makanan, jangan lupa tulis rincian pesanan kamu ya!</p>
                        <p class="price">Mulai dari Rp. 65.000</p>
                        <a href="{{ url('penggunaHandyGo/payment') }}">
                            <button>Pilih Jasa</button>
                        </a>
                    </div>
                </div>
                <div class="service-card">
                    <img src="{{ $assetFunction('pengguna/assets') }}/img/img_Layanan/ART-Info-DampakAngkat-03.jpg"
                        alt="Handy Food">
                    <div class="content">
                        <h3>Jasa Lainnya</h3>
                        <p>Nemenin kondangan, bagi brosur,
                            cosplay untuk jadi SPG, nemenin nobar,
                            jagain di rumah sakit, melayani apa…</p>
                        <p class="price">Mulai dari Rp. 100.000</p>
                        <a href="{{ url('penggunaHandyGo/payment') }}">
                            <button>Pilih Jasa</button>
                        </a>
                    </div>
                </div>
                <div class="service-card">
                    <img src="{{ $assetFunction('pengguna/assets') }}/img/img_Layanan/Jokowi_mantau.jpg"
                        alt="Handy Food">
                    <div class="content">
                        <h3>SPY/ Mata-mata</h3>
                        <p>Mitra yang menjadi mata-mata adalah mitra khusus. </p>
                        <p class="price">Mulai dari Rp. 360.000</p>
                        <a href="{{ url('penggunaHandyGo/payment') }}">
                            <button>Pilih Jasa</button>
                        </a>
                    </div>
                </div>
                <div class="service-card">
                    <img src="{{ $assetFunction('pengguna/assets') }}/img/img_Layanan/Screenshot_20240703_100927_Gallery.jpg"
                        alt="Handy Food">
                    <div class="content">
                        <h3>Buang Sampah</h3>
                        <p>Buang sampah jadi lebih mudah pake
                            jasa santo suruh.</p>
                        <p class="price">Mulai dari Rp. 130.000</p>
                        <a href="{{ url('penggunaHandyGo/payment') }}">
                            <button>Pilih Jasa</button>
                        </a>
                    </div>
                </div>
                <div class="service-card">
                    <img src="{{ $assetFunction('pengguna/assets') }}/img/img_Layanan/556302340423bd98328b4567.jpeg"
                        alt="Handy Food">
                    <div class="content">
                        <h3>Bersihin teras</h3>
                        <p>Bantu kamu bersihin lingkungan depan rumah</p>
                        <p class="price">Mulai dari Rp. 100.000</p>
                        <a href="{{ url('penggunaHandyGo/payment') }}">
                            <button>Pilih Jasa</button>
                        </a>
                    </div>
                </div>

                <!--? Services Area End -->
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>

</body>

</html>
