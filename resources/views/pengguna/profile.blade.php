<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Handy Go - Profile</title>
    <!-- Helper Function -->
    @php
        $assetFunction = app()->environment('local') ? 'asset' : 'secure_asset';
    @endphp
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }



        .container {
            max-width: 1200px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .container h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .tab-menu {
            display: flex;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .tab-menu a {
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            border-bottom: 2px solid transparent;
        }

        .tab-menu a.active {
            color: #007bff;
            border-color: #007bff;
        }

        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        form label {
            font-size: 14px;
            color: #555;
        }

        form input,
        form textarea {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        form input[type="file"] {
            border: none;
        }

        .button-primary {
            grid-column: span 2;
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
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
                        <a href="{{ url('penggunaHandyGo/profile') }}"
                            style="text-decoration: none; font-size: 16px; color: #333;">Sardor</a>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <div class="container">
        <h1>PROFILE</h1>
        <div class="tab-menu">
            <a href="{{ url('penggunaHandyGo/profile') }}" class="active">Profil</a>
            <a href="{{ url('penggunaHandyGo/pemesanan') }}">Pemesanan</a>
            <a href="{{ url('penggunaHandyGo/history') }}">History</a>
            <a href="{{ url('penggunaHandyGo') }}">Logout</a>
        </div>

        <form>
            <label for="photo">Photo Profile</label>
            <input type="file" id="photo" name="photo">

            <label for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name" value="Aria Dillah">

            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="ariadillah56@gmail.com">

            <label for="whatsapp">Whatsapp</label>
            <input type="tel" id="whatsapp" name="whatsapp" value="085841019209">

            <label for="dob">Tanggal Lahir</label>
            <input type="date" id="dob" name="dob" value="2005-10-04">

            <label for="address">Alamat</label>
            <textarea id="address" name="address">Jalan Raya Jasinga-Tenjo</textarea>

            <button type="submit" class="button-primary">Simpan</button>
        </form>
    </div>

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

</body>

</html>
