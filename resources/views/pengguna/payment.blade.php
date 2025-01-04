<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Handy Go - Payment</title>

    @php
        $assetFunction = app()->environment('local') ? 'asset' : 'secure_asset';
    @endphp
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }

        textarea {
            resize: none;
            height: 80px;
        }

        input[type="text"],
        input[type="tel"],
        input[type="email"],
        input[type="date"],
        input[type="time"] {
            padding-right: 15px;
        }

        select {
            padding-right: 15px;
        }

        textarea {
            padding-right: 15px;
        }

        main {
            padding: 20px;
        }

        .service-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .service-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .service-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .service-card .content {
            padding: 15px;
        }

        .service-card h3 {
            margin: 0 0 10px;
            font-size: 18px;
        }

        .service-card p {
            margin: 0 0 15px;
            color: #666;
        }

        .service-card .price {
            font-weight: bold;
            margin-bottom: 15px;
        }

        .service-card button {
            text-align: center;
            background-color: #3ab8ff;
            margin-left: 50px;
            color: white;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            width: 250px;
        }

        footer {
            background-color: #3ab8ff;
            color: white;
            padding: 5px;
            margin-top: 0px;
        }
    </style>
</head>

<body>
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
                                <a href="./index.html"
                                    style="text-decoration: none; color: #333; font-size: 16px;">Beranda</a>
                            </li>
                            <li style="margin-right: 20px;">
                                <a href="./layanan.html"
                                    style="text-decoration: none; color: #333; font-size: 16px;">Layanan</a>
                            </li>
                            <li style="margin-right: 20px;">
                                <a href="./tentangkami.html"
                                    style="text-decoration: none; color: #333; font-size: 16px;">Tentang Kami</a>
                            </li>
                        </ul>
                    </nav>

                    <!-- Button -->
                    <a href="./login.html"
                        style="text-decoration: none; background: #007bff; color: #fff; padding: 8px 16px; border-radius: 20px; font-size: 16px; display: inline-flex; align-items: center; margin-left: 20px;">
                        Daftar Mitra Baru <span style="margin-left: 8px;">→</span>
                    </a>

                    <!-- Profile -->
                    <div
                        style="margin-left: 20px; display: flex; align-items: center; border: 1px solid #ddd; padding: 5px 10px; border-radius: 20px;">
                        <img src="{{ $assetFunction('pengguna/assets') }}/img/logo/user.jpg" alt="Profile"
                            style="width: 30px; height: 30px; border-radius: 50%; margin-right: 10px;">
                        <a href="./profile.html" style="text-decoration: none; font-size: 16px; color: #333;">Sardor</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <h1 style="text-align: left; margin-left: 200px;">Layanan</h1>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Form Handy Go</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f9f9f9;
                }

                .container {
                    max-width: 800px;
                    margin: 20px auto;
                    padding: 20px;
                    background: #fff;
                    border-radius: 8px;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                }

                h2 {
                    font-size: 24px;
                    margin-bottom: 20px;
                    color: #333;
                }

                label {
                    display: block;
                    font-size: 14px;
                    margin-bottom: 8px;
                    color: #555;
                }

                input,
                select,
                textarea {
                    width: 100%;
                    padding: 10px;
                    margin-bottom: 20px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    font-size: 14px;
                }

                textarea {
                    resize: none;
                    height: 80px;
                }

                .radio-group {
                    display: flex;
                    gap: 20px;
                }

                .radio-group label {
                    display: flex;
                    align-items: center;
                    gap: 5px;
                }

                .checkbox {
                    display: flex;
                    margin-right: 600px;
                }

                .checkbox input {
                    margin-right: 10px;
                }

                button {
                    background-color: #007BFF;
                    color: white;
                    border: none;
                    padding: 10px 20px;
                    font-size: 16px;
                    border-radius: 4px;
                    cursor: pointer;
                    transition: background-color 0.3s;
                }

                button:hover {
                    background-color: #0056b3;
                }


                #whatsapp {
                    margin-right: 100px;
                }
            </style>
        </head>

        <body>
            <div class="container">
                <h2>Informasi Pelanggan</h2>
                <form action="#" method="POST">
                    <label for="whatsapp">Nomor WhatsApp:</label>
                    <input type="text" id="whatsapp" name="whatsapp" placeholder="081316841112" required>

                    <label for="address">Alamat Lengkap:</label>
                    <input type="text" id="address" name="address" placeholder="Perumahan Pura Bojonggede"
                        required>

                    <h2>Informasi Pesanan</h2>

                    <label for="service">Pilihan Jasa:</label>
                    <select id="service" name="service" required>
                        <option value="">Pilih Jasa</option>
                        <option value="antar_jemput">Antar Jemput</option>
                        <option value="spy_mata_mata">SPY/ Mata-mata</option>
                        <option value="nemenin_olahraga">Nemenin olahraga</option>
                        <option value="handy_food">HandyFood</option>
                        <option value="full_home_cleaning">Full Home Cleaning</option>
                    </select>

                    <label for="price">Harga Penawaran:</label>
                    <input type="number" id="price" name="price" placeholder="Rp. 360.000" required>

                    <label for="hours">Jam Operasional:</label>
                    <p id="hours" name="hours">07:00 - 00:00</p>

                    <label for="date">Tanggal Pelaksanaan:</label>
                    <input type="date" id="date" name="date" required>

                    <label for="time">Waktu/Jam:</label>
                    <input type="time" id="time" name="time" required>

                    <label>Pilih Gender Rekan Jasa:</label>
                    <div class="radio-group">
                        <label><input type="radio" name="gender" value="Pria" required> Pria</label>
                        <label><input type="radio" name="gender" value="Wanita" required> Wanita</label>
                        <label><input type="radio" name="gender" value="Bebas" required> Bebas</label>
                    </div>

                    <label for="description">Deskripsi:</label>
                    <textarea id="description" name="description" placeholder="Mata-matai Ari" required></textarea>

                    <h2>Informasi Pembayaran</h2>

                    <label for="payment">Pembayaran Melalui:</label>
                    <select id="payment" name="payment" required>
                        <option value="">Pilih metode pembayaran</option>
                        <option value="bank">Transfer Bank</option>
                        <option value="gopay">GoPay</option>
                        <option value="dana">Dana</option>
                        <option value="ovo">OVO</option>
                    </select>

                    <div class="checkbox">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">Saya setuju dengan <a href="#">Syarat & Ketentuan</a></label>
                    </div><br><br><br>

                    <button type="button" onclick="location.href='Pemesanan.html'">Submit</button>

                </form>
            </div>

            <footer
                style="background-color: #377D98; color: white; padding: 20px 50px; font-family: 'Calibri', sans-serif;">
                <div style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 30px;">
                    <!-- Section 1: Support Info -->
                    <div style="flex: 1; min-width: 200px;">
                        <h4 style="font-size: 18px; margin-bottom: 10px; font-weight: bold; color: white;">Butuh
                            Bantuan? Hubungi Tim Support Kami</h4>
                        <p style="margin: 0 0 15px; font-size: 14px; color: white;">Senin - Minggu 06.00 - 22.00 (WIB)
                        </p>
                    </div>
                    <!-- Kontak Kami Button -->
                    <div style="min-width: 150px; text-align: right;">
                        <a href="https://wa.me/6281316814112"
                            style="background-color: #47A6CE; border: none; padding: 10px 20px; color: white; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block;">
                            Kontak Kami
                        </a>
                    </div>
                </div>

                <div
                    style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 30px; margin-top: 20px;">
                    <!-- Section 2: Informasi HandyGo -->
                    <div style="flex: 1; min-width: 200px;">
                        <h4 style="font-size: 18px; margin-bottom: 10px; font-weight: bold; color: white;">INFORMASI
                            HANDYGO</h4>
                        <ul style="list-style: none; padding: 0; margin: 0; line-height: 2;">
                            <li style="font-size: 14px; color: white;">Beranda</li>
                            <li style="font-size: 14px; color: white;">Layanan</li>
                            <li style="font-size: 14px; color: white;">Tentang Kami</li>
                            <li style="font-size: 14px; color: white;">Kontak Kami</li>
                        </ul>
                    </div>

                    <!-- Section 3: Hubungi Kami -->
                    <div style="flex: 1; min-width: 200px;">
                        <h4 style="font-size: 18px; margin-bottom: 10px; font-weight: bold; color: white;">HUBUNGI KAMI
                        </h4>
                        <ul style="list-style: none; padding: 0; margin: 0; line-height: 2;">
                            <li style="font-size: 14px; color: white;">📞 08131681412</li>
                            <li style="font-size: 14px; color: white;">📍 STT TERPADU NURUL FIKRI</li>
                            <li style="font-size: 14px; color: white;">✉️ handygo@gmail.com</li>
                        </ul>
                    </div>

                    <!-- Section 4: Disclaimer -->
                    <div style="flex: 2; min-width: 250px;">
                        <p style="font-size: 14px; line-height: 1.8; margin: 0; color: white;">Handy Go tidak
                            bertanggung jawab atas transaksi langsung yang dilakukan pelanggan dengan mitra (tidak
                            melalui admin).</p>
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

        </body>

        </html>

</body>

</html>
