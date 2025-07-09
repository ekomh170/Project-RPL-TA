# HandyGo - Laravel + AdminLTE

HandyGo adalah aplikasi berbasis web yang dirancang untuk menghubungkan pengguna dengan penyedia jasa harian. Proyek ini menggunakan **Laravel** sebagai backend framework dan **AdminLTE** sebagai template frontend untuk admin.

## Deskripsi Proyek yang Lebih Mendalam
HandyGo dikembangkan untuk menjawab kebutuhan masyarakat dalam mendapatkan layanan bantuan harian yang cepat, terpercaya, dan terintegrasi. Latar belakang proyek ini adalah tantangan yang sering dihadapi oleh individu, seperti lansia, masyarakat sibuk, atau mereka yang memiliki keterbatasan fisik, dalam mengakses bantuan untuk aktivitas rutin, termasuk membersihkan rumah, belanja, atau mendampingi lansia. 

**Masalah yang Diatasi**:
1. **Keterbatasan akses layanan**: Banyak individu kesulitan menemukan penyedia jasa yang dapat dipercaya secara manual.
2. **Efisiensi waktu**: Proses pencarian jasa secara tradisional memakan waktu lama dan sering kali tidak efisien.
3. **Keamanan dan kepercayaan**: Pengguna memerlukan sistem yang menjamin kualitas dan keamanan jasa yang mereka pesan.

**Solusi yang Ditawarkan oleh HandyGo**:
- Platform berbasis web yang memungkinkan pengguna mencari dan memesan jasa dengan cepat dan aman.
- Fitur notifikasi dan komunikasi real-time untuk memastikan koordinasi yang optimal antara pengguna dan penyedia jasa.
- Sistem pembayaran terintegrasi dengan berbagai opsi, termasuk e-wallet, bank transfer, dan cash.
- Review dan rating dari pengguna untuk meningkatkan transparansi dan kredibilitas penyedia jasa.

HandyGo tidak hanya mempermudah pengguna mendapatkan layanan yang mereka butuhkan, tetapi juga menciptakan peluang kerja baru bagi penyedia jasa dengan akses pasar yang lebih luas.

## Identitas Kampus dan Program Studi
- **Kampus**: Sekolah Tinggi Teknologi Terpadu Nurul Fikri
- **Program Studi**: Teknik Informatika

## Anggota Kelompok
- **Eko Muchamad Haryono** - Scrum Master
- **Muhammad Andhika Thata** - Product Owner
- **Muhamad Sayyid Fadhil** - Developer
- **Fairuz Shofyah Mumtaz** - Developer
- **Najwa Nur Salimah** - Developer
- **Aria Dillah** - Developer
- **Muhammad Zen Alby** - Medkre
- **Nurhayati** - Medkre

## Prasyarat
Pastikan perangkat Anda memenuhi persyaratan berikut sebelum memulai pengembangan:

- PHP >= 8.1
- Composer
- Node.js & npm
- MySQL/MariaDB (atau database lain yang didukung Laravel)
- Git

---

## 📚 Dokumentasi Optimasi Database & Model

Proyek ini telah melalui proses optimasi database dan model yang komprehensif. Seluruh dokumentasi tersedia di:

**📁 [`docs/plan/`](./docs/plan/)** - Dokumentasi lengkap optimasi proyek

### Quick Links:
- 🎯 [**Project Summary**](./docs/plan/reports/project-summary.md) - Ringkasan lengkap optimasi
- 📊 [**Final ERD**](./docs/plan/erd/final-model-erd.md) - Entity Relationship Diagram final
- 🛠️ [**Implementation Guide**](./docs/plan/reports/implementation-guide.md) - Panduan implementasi
- 🔧 [**Model Relationships**](./docs/plan/models/relationships.md) - Dokumentasi relasi model

---

## Komponen AdminLTE
AdminLTE digunakan sebagai template frontend. File utama template terletak di:
- **resources/views/admin/**: Halaman admin berbasis AdminLTE.
- **resources/js/**: Konfigurasi dan custom JS untuk AdminLTE.

Gunakan command berikut untuk membangun ulang asset jika Anda melakukan perubahan:
```bash
npm run build
```

---

## Fitur yang Dikembangkan
- Autentikasi (Register, Login, Logout)
- Manajemen Pengguna
- Manajemen Jasa dan Pesanan
- Dasbor Admin menggunakan AdminLTE
- Notifikasi Real-Time
- Integrasi Pembayaran (e-Wallet, Bank Transfer, Cash)
- Laporan dan Analitik untuk Admin

---

## Penjelasan Diagram
1. **Use Case Diagram**:
   Diagram ini menunjukkan interaksi utama antara pengguna, penyedia jasa, dan admin dengan fitur-fitur utama aplikasi seperti login, pengelolaan jasa, dan pembayaran. Aktor utama meliputi pengguna, penyedia jasa, dan admin, yang masing-masing memiliki akses ke fitur yang relevan.

2. **Activity Diagram**:
   Diagram ini menjelaskan alur proses utama, seperti login pengguna, pencarian jasa, registrasi penyedia jasa, hingga pembayaran layanan. Misalnya, pada login pengguna, sistem akan memvalidasi kredensial dengan database sebelum memberikan akses.

3. **Class Diagram**:
   Diagram ini mendeskripsikan struktur statis aplikasi, mencakup entitas utama seperti Admin, Pengguna, Penyedia Jasa, Jasa, Transaksi, Pemesanan Jasa, dan Notifikasi. Relasi antar kelas meliputi:
   - Satu pengguna dapat memiliki banyak transaksi (One-to-Many).
   - Satu penyedia jasa dapat menawarkan banyak jasa (One-to-Many).
   - Setiap transaksi terkait dengan satu pemesanan jasa (One-to-One).

4. **Sequence Diagram**:
   Diagram ini menggambarkan interaksi antar objek secara berurutan berdasarkan waktu, seperti bagaimana pengguna mencari layanan, penyedia jasa menerima pesanan, dan admin memproses transaksi. Contoh: Saat pengguna mengisi form pemesanan, data dikirim ke sistem untuk diteruskan kepada penyedia jasa yang sesuai.

---

## Opsional
Untuk memahami struktur proyek, Anda dapat melihat:
- **app/**: Logika aplikasi (Controllers, Models, Middleware).
- **resources/views/**: File tampilan blade Laravel.
- **resources/js/**: File JavaScript untuk AdminLTE.
- **public/**: Asset publik (CSS, JS, gambar).
- **routes/**: File rute aplikasi (web.php, api.php).

---

## Lisensi
Proyek ini dilisensikan di bawah [MIT License](LICENSE).
