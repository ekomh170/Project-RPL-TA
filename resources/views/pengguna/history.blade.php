<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Handy Go - History</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f8f9fa;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            color: #fff;
        }

        .badge.lunas {
            background-color: #28a745;
        }

        .badge.belum-lunas {
            background-color: #dc3545;
        }

        .badge.progress {
            background-color: #28a745;
            color: #ffff;
        }

    </style>
</head>
<body>
    <header>
        <div style="background: #fff; padding: 10px 20px; border-bottom: 1px solid #ddd;">
            <div style="display: flex; align-items: center; justify-content: space-between; max-width: 1200px; margin: 0 auto;">
                <!-- Left Section: Logo -->
                <div>
                    <a href="#home">
                        <img src="assets/img/logo/logohandygo.png" alt="Logo" style="height: 100px;">
                    </a>
                </div>
    
                <!-- Right Section: Navigation Links, Button, and Profile -->
                <div style="display: flex; align-items: center;">
                    <!-- Navigation Links -->
                    <nav>
                        <ul style="list-style: none; margin: 0; padding: 0; display: flex;">
                            <li style="margin-right: 20px;">
                                <a href="./index.html" style="text-decoration: none; color: #333; font-size: 16px;">Beranda</a>
                            </li>
                            <li style="margin-right: 20px;">
                                <a href="./layanan.html" style="text-decoration: none; color: #333; font-size: 16px;">Layanan</a>
                            </li>
                            <li style="margin-right: 20px;">
                                <a href="./tentangkami.html" style="text-decoration: none; color: #333; font-size: 16px;">Tentang Kami</a>
                            </li>
                        </ul>
                    </nav>
    
                    <!-- Button -->
                    <a href="./login.html" style="text-decoration: none; background: #007bff; color: #fff; padding: 8px 16px; border-radius: 20px; font-size: 16px; display: inline-flex; align-items: center; margin-left: 20px;">
                        Daftar Mitra Baru <span style="margin-left: 8px;">→</span>
                    </a>
    
                    <!-- Profile -->
                    <div style="margin-left: 20px; display: flex; align-items: center; border: 1px solid #ddd; padding: 5px 10px; border-radius: 20px;">
                        <img src="assets/img/logo/user.jpg" alt="Profile" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 10px;">
                        <a href="./profile.html" style="text-decoration: none; font-size: 16px; color: #333;">Sardor</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <h1>History</h1>
        <div class="tab-menu">
            <a href="Profile.html">Profil</a>
            <a href="Pemesanan.html">Pemesanan</a>
            <a href="History.html" class="active">History</a>
            <a href="#">Logout</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Jasa</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Pekerja</th>
                    <th>Alamat</th>
                    <th>Pembayaran</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Pindahan</td>
                    <td>04 Okt 2024</td>
                    <td>13:00</td>
                    <td>Rudi</td>
                    <td>Bojong</td>
                    <td>Berhasil</td>
                    <td><span class="badge progress">Selesai</span></td>
                </tr>
                <tr>
                    <td>Buang Sampah</td>
                    <td>Bojong</td>
                    <td>10 Jan 2024</td>
                    <td>14:00</td>
                    <td>Yanto</td>
                    <td>Refund</td>
                    <td><span class="badge belum-lunas">Batal</span></td>
                </tr>
                <tr>
                    <td>Angkut Barang</td>
                    <td>Bojong</td>
                    <td>25 Feb 2024</td>
                    <td>15:00</td>
                    <td>Jordan</td>
                    <td>Refund</td>
                    <td><span class="badge belum-lunas">Batal</span></td>
                </tr>
                <tr>
                    <td>Antar / Jemput</td>
                    <td>Bojong</td>
                    <td>12 Mar 2024</td>
                    <td>16:00</td>
                    <td>Rangga</td>
                    <td>Berhasil</td>
                    <td><span class="badge progress">Selesai</span></td>
                </tr>
                <tr>
                    <td>Nemenin Olahraga</td>
                    <td>Bojong</td>
                    <td>15 Mei 2024</td>
                    <td>17:00</td>
                    <td>Tatang</td>
                    <td>Berhasil</td>
                    <td><span class="badge progress">Selesai</span></td>
                </tr>
                <tr>
                    <td>SPY / Mata - Mata</td>
                    <td>Bojong</td>
                    <td>09 Des 2024</td>
                    <td>18:00</td>
                    <td>Rendi</td>
                    <td>Berhasil</td>
                    <td><span class="badge progress">Selesai</span></td>
                </tr>
                <tr>
                    <td>Full Home Cleaning</td>
                    <td>Bojong</td>
                    <td>20 Nov 2024</td>
                    <td>19:00</td>
                    <td>Stepen</td>
                    <td>Berhasil</td>
                    <td><span class="badge progress">Selesai</span></td>
                </tr>
                <tr>
                    <td>Jasa Lainnya</td>
                    <td>Bojong</td>
                    <td>19 Apr 2024</td>
                    <td>20:00</td>
                    <td>Mawi</td>
                    <td>Berhasil</td>
                    <td><span class="badge progress">Selesai</span></td>
                </tr>
                <tr>
                    <td>Basic Daily Cleaning</td>
                    <td>Bojong</td>
                    <td>10 Agu 2024</td>
                    <td>21:00</td>
                    <td>Robert</td>
                    <td>Berhasil</td>
                    <td><span class="badge progress">Selesai</span></td>
                </tr>
            </tbody>
        </table>
    </div>

    <footer style="background-color: #377D98; color: white; padding: 20px 50px; font-family: 'Calibri', sans-serif;">
        <div style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 30px;">
            <!-- Section 1: Support Info -->
            <div style="flex: 1; min-width: 200px;">
                <h4 style="font-size: 18px; margin-bottom: 10px; font-weight: bold; color: white;">Butuh Bantuan? Hubungi Tim Support Kami</h4>
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
                <h4 style="font-size: 18px; margin-bottom: 10px; font-weight: bold; color: white;">INFORMASI HANDYGO</h4>
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
                <p style="font-size: 14px; line-height: 1.8; margin: 0; color: white;">Handy Go tidak bertanggung jawab atas transaksi langsung yang dilakukan pelanggan dengan mitra (tidak melalui admin).</p>
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
