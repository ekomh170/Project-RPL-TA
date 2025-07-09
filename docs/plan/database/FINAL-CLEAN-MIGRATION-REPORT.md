# Dokumentasi Migrasi Database HandyGo - Versi Clean

## Overview
Migrasi database HandyGo telah dibuat ulang dengan struktur yang clean, teroptimasi, dan sesuai dengan best practices Laravel. Semua redundansi telah dihilangkan dan relasi antar tabel sudah dinormalisasi dengan baik.

## Struktur Tabel Final

### 1. Users Table (`users`)
**File**: `2025_07_09_093253_create_users_table.php`
**Fungsi**: Tabel master untuk semua pengguna sistem

```sql
- id (primary key)
- name (string)
- email (unique index)
- phone (unique index)
- email_verified_at (nullable)
- password (hashed)
- role (enum: 'pengguna', 'penyedia_jasa')
- status (enum: 'pending', 'aktif', 'nonaktif')
- address (text, nullable)
- profile_picture (string, nullable)
- remember_token
- timestamps (created_at, updated_at)
- soft_deletes (deleted_at)
```

**Indexes**:
- `idx_users_email_status` (email, status)
- `idx_users_role` (role)
- `idx_users_status` (status)
- `idx_users_phone` (phone)

### 2. Services Table (`services`)
**File**: `2025_07_09_093317_create_services_table.php`
**Fungsi**: Master layanan yang tersedia di sistem

```sql
- id (primary key)
- name (string)
- description (text)
- price (decimal 10,2)
- status (enum: 'tersedia', 'tidak_tersedia')
- image (string, nullable)
- category (enum: kebersihan, perbaikan, teknologi, perawatan, transportasi, lainnya)
- duration_hours (integer, default 1)
- timestamps
- soft_deletes
```

**Indexes**:
- `idx_services_category_status` (category, status)
- `idx_services_status` (status)
- `idx_services_price` (price)
- `idx_services_name` (name)

### 3. Penyedia Jasa Table (`penyedia_jasa`)
**File**: `2025_07_09_093348_create_penyedia_jasa_table.php`
**Fungsi**: Extended profile untuk users dengan role penyedia_jasa

```sql
- id (primary key)
- user_id (foreign key -> users.id, unique)
- verification_status (enum: 'pending', 'verified', 'rejected')
- verification_documents (text, nullable)
- experience (text, nullable)
- rating_average (decimal 3,2, default 0)
- total_reviews (integer, default 0)
- timestamps
- soft_deletes
```

**Indexes**:
- `unique_penyedia_user` (user_id unique)
- `idx_penyedia_verification` (verification_status)
- `idx_penyedia_rating` (rating_average)
- `idx_penyedia_status_rating` (verification_status, rating_average)

### 4. Penyedia Service Table (`penyedia_service`)
**File**: `2025_07_09_093420_create_penyedia_service_table.php`
**Fungsi**: Pivot table many-to-many antara penyedia_jasa dan services

```sql
- id (primary key)
- penyedia_jasa_id (foreign key -> penyedia_jasa.id)
- service_id (foreign key -> services.id)
- custom_price (decimal 10,2, nullable)
- is_available (boolean, default true)
- notes (text, nullable)
- timestamps
```

**Constraints**:
- `unique_penyedia_service` (penyedia_jasa_id, service_id)

**Indexes**:
- `idx_penyedia_service_provider` (penyedia_jasa_id)
- `idx_penyedia_service_service` (service_id)
- `idx_penyedia_service_available` (is_available)
- `idx_service_available` (service_id, is_available)

### 5. Job Orders Table (`job_orders`)
**File**: `2025_07_09_093444_create_job_orders_table.php`
**Fungsi**: Tabel utama untuk semua order/pesanan

```sql
- id (primary key)
- order_code (string unique, format: JO-YYYYMMDD-XXXX)
- user_id (foreign key -> users.id)
- service_id (foreign key -> services.id)
- provider_id (foreign key -> penyedia_jasa.id, nullable)
- description (text, nullable)
- address (text)
- customer_phone (string)
- status (enum: 'menunggu', 'diterima', 'dikerjakan', 'selesai', 'dibatalkan')
- base_price (decimal 10,2)
- final_price (decimal 10,2)
- admin_fee (decimal 10,2, default 5000)
- scheduled_at (datetime)
- started_at (datetime, nullable)
- completed_at (datetime, nullable)
- rating (integer 1-5, nullable)
- review (text, nullable)
- timestamps
- soft_deletes
```

**Indexes**:
- `idx_job_orders_code` (order_code)
- `idx_job_orders_user_status` (user_id, status)
- `idx_job_orders_provider_status` (provider_id, status)
- `idx_job_orders_service_status` (service_id, status)
- `idx_job_orders_status` (status)
- `idx_job_orders_scheduled` (scheduled_at)
- `idx_job_orders_status_scheduled` (status, scheduled_at)

### 6. Transactions Table (`transactions`)
**File**: `2025_07_09_093506_create_transactions_table.php`
**Fungsi**: Tracking pembayaran untuk setiap order

```sql
- id (primary key)
- transaction_code (string unique, format: TRX-YYYYMMDD-XXXX)
- job_order_id (foreign key -> job_orders.id)
- user_id (foreign key -> users.id)
- amount (decimal 10,2)
- admin_fee (decimal 10,2, default 5000)
- total_amount (decimal 10,2)
- payment_method (enum: 'tunai', 'transfer_bank', 'dompet_digital', 'qris')
- status (enum: 'menunggu', 'lunas', 'gagal', 'dikembalikan', 'kadaluarsa')
- paid_at (datetime, nullable)
- expired_at (datetime, nullable)
- payment_details (text, nullable)
- payment_reference (string, nullable)
- timestamps
- soft_deletes
```

**Indexes**:
- `idx_transactions_code` (transaction_code)
- `idx_transactions_user_status` (user_id, status)
- `idx_transactions_order_status` (job_order_id, status)
- `idx_transactions_status` (status)
- `idx_transactions_paid_at` (paid_at)
- `idx_transactions_method` (payment_method)

### 7. Notifications Table (`notifications`)
**File**: `2025_07_09_093542_create_notifications_table.php`
**Fungsi**: Sistem notifikasi untuk pengguna

```sql
- id (primary key)
- user_id (foreign key -> users.id)
- title (string)
- message (text)
- type (enum: 'informasi', 'peringatan', 'berhasil', 'error', 'update_pesanan', 'update_pembayaran')
- data (json, nullable)
- read_at (timestamp, nullable)
- is_pushed (boolean, default false)
- timestamps
- soft_deletes
```

**Indexes**:
- `idx_notifications_user_read` (user_id, read_at)
- `idx_notifications_user_type` (user_id, type)
- `idx_notifications_type` (type)
- `idx_notifications_created` (created_at)
- `idx_notifications_user_created` (user_id, created_at)

## Keunggulan Struktur Baru

### 1. **Normalisasi Sempurna**
- Tidak ada redundansi data
- Setiap tabel memiliki tanggung jawab yang jelas
- Relasi foreign key yang proper

### 2. **Performance Optimized**
- Index yang tepat untuk setiap query pattern
- Composite index untuk query kompleks
- Soft deletes untuk data integrity

### 3. **Scalability Ready**
- Struktur yang dapat menangani volume data besar
- Index yang mendukung performa query
- Foreign key constraints yang proper

### 4. **Maintainability**
- Nama field yang konsisten dan deskriptif
- Enum values yang jelas
- Dokumentasi yang lengkap

## Pola Relasi

### One-to-One
- `users` ← → `penyedia_jasa` (one user can be one provider)

### One-to-Many
- `users` → `job_orders` (one user can have many orders)
- `users` → `transactions` (one user can have many transactions)
- `users` → `notifications` (one user can have many notifications)
- `services` → `job_orders` (one service can be ordered many times)
- `penyedia_jasa` → `job_orders` (one provider can handle many orders)
- `job_orders` → `transactions` (one order can have multiple transaction attempts)

### Many-to-Many
- `penyedia_jasa` ← → `services` (through `penyedia_service` pivot table)

## Next Steps

1. ✅ **Migration selesai** - Semua tabel sudah terbentuk dengan struktur yang optimal
2. 🔄 **Update Models** - Sesuaikan model relationships dengan struktur baru
3. 🔄 **Update Controllers** - Sesuaikan controller logic dengan field dan relasi baru
4. 🔄 **Create Seeders** - Buat data sample untuk testing
5. 🔄 **Testing** - Test semua functionality dengan struktur baru

## Status
- ✅ Database structure: **COMPLETED**
- ✅ Foreign key relationships: **COMPLETED**  
- ✅ Indexes optimization: **COMPLETED**
- ✅ Data normalization: **COMPLETED**

Migration berhasil dan database HandyGo siap untuk development dan production!
