# 📊 ERD Database HandyGo - SEBELUM PERBAIKAN (Migration Asli)

⚠️ **PERHATIAN**: Ini adalah struktur database ASLI yang bermasalah. Untuk struktur yang sudah diperbaiki, lihat file `fixed-erd.md`

```mermaid
erDiagram
    %% Tabel Users - Autentikasi Multi-Role
    USERS {
        bigint id PK "ID unik pengguna"
        varchar username "Username opsional"
        varchar name "Nama lengkap wajib"
        varchar email "Email unik untuk login"
        timestamp email_verified_at "Waktu verifikasi email"
        varchar password "Password terenkripsi"
        varchar nomor_wa "Nomor WhatsApp"
        text alamat_lengkap "Alamat lengkap pengguna"
        enum role "admin-penyedia_jasa-pengguna"
        varchar remember_token "Token remember me Laravel"
        timestamp created_at "Waktu dibuat"
        timestamp updated_at "Waktu diupdate"
    }

    %% Tabel Penyedia Jasa - Profil Lengkap Provider
    PENYEDIA_JASA {
        bigint id PK "ID unik penyedia jasa"
        varchar nama "Nama penyedia jasa"
        varchar foto "Path foto profil"
        bigint user_id FK "FK ke users-id CASCADE"
        varchar email "Email penyedia jasa"
        varchar telpon "Nomor telepon kontak"
        enum gender "Laki-Laki atau Perempuan"
        varchar alamat "Alamat penyedia jasa"
        date tanggal_lahir "Tanggal lahir"
        timestamp created_at "Waktu dibuat"
        timestamp updated_at "Waktu diupdate"
    }

    %% Tabel Services - Katalog Layanan
    SERVICES {
        bigint id PK "ID unik layanan"
        varchar nama_jasa "Nama layanan"
        varchar kategori "Kategori layanan"
        decimal harga "Harga layanan decimal-10-2"
        timestamp created_at "Waktu dibuat"
        timestamp updated_at "Waktu diupdate"
    }

    %% Tabel Job Orders - Pesanan dari Customer
    JOB_ORDERS {
        bigint id PK "ID unik pesanan"
        varchar pembayaran "Metode pembayaran"
        bigint user_id FK "FK ke users-id customer"
        bigint nama_pekerja FK "FK ke penyedia_jasa-NAMA-MISLEADING"
        varchar waktu_kerja "Waktu kerja diminta"
        varchar nama_jasa "Nama jasa dipesan"
        decimal harga_penawaran "Harga penawaran decimal-10-2"
        date tanggal_pelaksanaan "Tanggal pelaksanaan"
        enum gender "Preferensi Laki-laki-Perempuan"
        varchar deskripsi "Deskripsi pekerjaan"
        varchar informasi_pembayaran "Info pembayaran"
        varchar nomor_telepon "Nomor telepon nullable"
        varchar bukti "Bukti pembayaran nullable"
        enum status "Status Selesai-Batal nullable"
        timestamp created_at "Waktu dibuat"
        timestamp updated_at "Waktu diupdate"
    }

    %% Tabel Transactions - Catatan Transaksi
    TRANSACTIONS {
        bigint id PK "ID unik transaksi"
        bigint user_id FK "FK ke users-id customer"
        bigint penyedia_jasa_id FK "FK ke users-SALAH-harusnya-penyedia_jasa"
        varchar metode_pembayaran "Metode pembayaran"
        date tanggal "Tanggal transaksi"
        varchar tipe "Tipe transaksi"
        varchar status "Status transaksi"
        varchar bukti "Bukti pembayaran nullable"
        timestamp created_at "Waktu dibuat"
        timestamp updated_at "Waktu diupdate"
    }

    %% Tabel Notifications - Sistem Notifikasi
    NOTIFICATIONS {
        bigint id PK "ID unik notifikasi"
        bigint user_id FK "FK ke users-id penerima"
        bigint penyedia_jasa_id FK "FK ke users-SALAH-harusnya-penyedia_jasa"
        text pesan "Isi pesan notifikasi"
        varchar status "Status notifikasi"
        timestamp created_at "Waktu dibuat"
        timestamp updated_at "Waktu diupdate"
    }

    %% Relasi Database Berdasarkan Migration Asli
    USERS ||--|| PENYEDIA_JASA : "One-to-One user_id"
    USERS ||--o{ JOB_ORDERS : "Customer places orders"
    USERS ||--o{ TRANSACTIONS : "Customer transactions"
    USERS ||--o{ TRANSACTIONS : "Provider payment MASALAH-FK"
    USERS ||--o{ NOTIFICATIONS : "User receives notifications"
    USERS ||--o{ NOTIFICATIONS : "Provider sends MASALAH-FK"

    PENYEDIA_JASA ||--o{ JOB_ORDERS : "Provider works on orders"
    
    %% Relasi yang HILANG di migration asli
    SERVICES ||..o{ JOB_ORDERS : "MISSING service_id FK"
    JOB_ORDERS ||..|| TRANSACTIONS : "MISSING job_order_id FK"
```

## 🚨 **PENJELASAN MASALAH DALAM DIAGRAM:**

### ❌ **Foreign Key Bermasalah:**
- `TRANSACTIONS.penyedia_jasa_id` → `users.id` (SALAH! Harusnya ke `penyedia_jasa.id`)
- `NOTIFICATIONS.penyedia_jasa_id` → `users.id` (SALAH! Harusnya ke `penyedia_jasa.id`)

### ❌ **Nama Field Misleading:**
- `JOB_ORDERS.nama_pekerja` seharusnya `penyedia_jasa_id`

### ❌ **Relasi Hilang (Garis Putus-putus):**
- `SERVICES` tidak terhubung ke `JOB_ORDERS` (tidak ada `service_id`)
- `JOB_ORDERS` tidak terhubung ke `TRANSACTIONS` (tidak ada `job_order_id`)

### 📝 **Keterangan Notasi:**
- `PK` = Primary Key
- `FK` = Foreign Key  
- `||--||` = One-to-One
- `||--o{` = One-to-Many
- `||..o{` = One-to-Many (MISSING/BERMASALAH)
- Garis putus-putus `..` = Relasi yang seharusnya ada tapi hilang

**Status**: Diagram ini menunjukkan struktur ASLI sesuai migration dengan semua masalah yang teridentifikasi.
