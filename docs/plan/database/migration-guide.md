# 🛠️ Panduan Migration Database HandyGo

## 📋 **Overview Migration**

Migration database HandyGo telah dirancang untuk memperbaiki struktur database yang bermasalah menjadi struktur yang optimal dan konsisten. Semua migration sudah production ready dan telah diuji.

## 📁 **Struktur Migration yang Dibuat**

### **1. Migration Perbaikan Utama**
```
database/migrations/
├── 2025_01_08_000001_fix_job_orders_table_relations.php
├── 2025_01_08_000002_enhance_transactions_table.php
├── 2025_01_08_000003_enhance_notifications_table.php
├── 2025_07_08_111706_fix_transactions_foreign_keys.php
└── 2025_07_08_111736_fix_notifications_foreign_keys.php
```

### **2. Migration Tambahan Sebelumnya**
```
database/migrations/
├── 2025_01_05_131141_add_nomor_telepon_and_bukti_to_job_orders_table.php
└── 2025_01_05_132221_add_status_to_job_orders_table.php
```

## 🔧 **Detail Migration yang Diimplementasikan**

### **1. Fix Job Orders Table Relations**
```php
// File: 2025_01_08_000001_fix_job_orders_table_relations.php

public function up()
{
    Schema::table('job_orders', function (Blueprint $table) {
        // Rename field yang misleading
        $table->renameColumn('nama_pekerja', 'penyedia_jasa_id');
        
        // Tambah service_id untuk relasi ke services (optional)
        $table->unsignedBigInteger('service_id')->nullable()->after('user_id');
        
        // Tambah foreign key constraint yang benar
        $table->foreign('penyedia_jasa_id')->references('id')->on('penyedia_jasa')->onDelete('cascade');
        $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
    });
}
```

### **2. Enhance Transactions Table**
```php
// File: 2025_01_08_000002_enhance_transactions_table.php

public function up()
{
    Schema::table('transactions', function (Blueprint $table) {
        // Tambah job_order_id untuk tracking transaksi per pesanan
        $table->unsignedBigInteger('job_order_id')->nullable()->after('penyedia_jasa_id');
        
        // Tambah total_amount untuk tracking nilai transaksi
        $table->decimal('total_amount', 10, 2)->nullable()->after('bukti');
        
        // Tambah foreign key constraint yang benar
        $table->foreign('job_order_id')->references('id')->on('job_orders')->onDelete('cascade');
        $table->foreign('penyedia_jasa_id')->references('id')->on('penyedia_jasa')->onDelete('cascade');
    });
}
```

### **3. Enhance Notifications Table**
```php
// File: 2025_01_08_000003_enhance_notifications_table.php

public function up()
{
    Schema::table('notifications', function (Blueprint $table) {
        // Tambah notification_type untuk kategorisasi notifikasi
        $table->enum('notification_type', ['job_order', 'payment', 'status_update', 'system', 'reminder'])
              ->default('system')
              ->after('status');
        
        // Tambah is_read untuk tracking status baca
        $table->boolean('is_read')->default(false)->after('notification_type');
        
        // Tambah foreign key constraint yang benar
        $table->foreign('penyedia_jasa_id')->references('id')->on('penyedia_jasa')->onDelete('cascade');
    });
}
```

### **4. Fix Foreign Keys (Transactions)**
```php
// File: 2025_07_08_111706_fix_transactions_foreign_keys.php

public function up()
{
    Schema::table('transactions', function (Blueprint $table) {
        // Drop foreign key yang salah
        $table->dropForeign(['penyedia_jasa_id']);
        
        // Tambah foreign key yang benar
        $table->foreign('penyedia_jasa_id')->references('id')->on('penyedia_jasa')->onDelete('cascade');
    });
}
```

### **5. Fix Foreign Keys (Notifications)**
```php
// File: 2025_07_08_111736_fix_notifications_foreign_keys.php

public function up()
{
    Schema::table('notifications', function (Blueprint $table) {
        // Drop foreign key yang salah
        $table->dropForeign(['penyedia_jasa_id']);
        
        // Tambah foreign key yang benar
        $table->foreign('penyedia_jasa_id')->references('id')->on('penyedia_jasa')->onDelete('cascade');
    });
}
```

## 🚀 **Cara Menjalankan Migration**

### **1. Cek Status Migration**
```bash
# Lihat migration yang sudah dan belum dijalankan
php artisan migrate:status
```

### **2. Jalankan Migration**
```bash
# Jalankan semua migration yang belum dijalankan
php artisan migrate

# Atau jalankan migration spesifik
php artisan migrate --path=database/migrations/2025_01_08_000001_fix_job_orders_table_relations.php
```

### **3. Rollback Migration (Jika Diperlukan)**
```bash
# Rollback batch terakhir
php artisan migrate:rollback

# Rollback migration spesifik
php artisan migrate:rollback --path=database/migrations/2025_01_08_000001_fix_job_orders_table_relations.php
```

## 📊 **Seeding Data**

### **1. Seeder yang Tersedia**
```bash
# Seeder untuk data realistis
php artisan db:seed --class=RealisticDataSeeder

# Seeder untuk data testing
php artisan db:seed --class=DatabaseSeeder
```

### **2. Fresh Migration + Seed**
```bash
# Fresh migration dan seed (untuk development)
php artisan migrate:fresh --seed

# Dengan seeder spesifik
php artisan migrate:fresh --seed --class=RealisticDataSeeder
```

## 🔍 **Verifikasi Migration**

### **1. Cek Struktur Database**
```bash
# Lihat struktur tabel
php artisan db:show

# Lihat kolom tabel spesifik
php artisan db:show --table=transactions
```

### **2. Test Relasi Model**
```bash
# Buka tinker untuk test
php artisan tinker

# Test relasi
>>> $user = User::first();
>>> $user->transactions; // Harus berhasil
>>> $user->penyediajasa; // Harus berhasil jika user adalah penyedia jasa
```

## ⚠️ **Troubleshooting Migration**

### **1. Error: Foreign Key Constraint**
```bash
# Jika ada error foreign key constraint
# Pastikan data yang ada sudah konsisten
# Bersihkan data yang tidak valid terlebih dahulu
```

### **2. Error: Column Already Exists**
```bash
# Jika error column already exists
# Cek apakah migration sudah pernah dijalankan
php artisan migrate:status
```

### **3. Error: Table Not Found**
```bash
# Pastikan urutan migration sudah benar
# Jalankan migration dalam urutan yang tepat
```

## 🎯 **Best Practices**

### **1. Backup Database**
```bash
# Backup database sebelum migration
# Untuk SQLite:
cp database/database.sqlite database/database.sqlite.backup

# Untuk MySQL:
# mysqldump -u username -p database_name > backup.sql
```

### **2. Testing Environment**
```bash
# Test di environment development dulu
# Pastikan semua berjalan lancar
# Baru deploy ke production
```

### **3. Monitoring**
```bash
# Monitor logs setelah migration
tail -f storage/logs/laravel.log

# Monitor performance
# Gunakan tools seperti Laravel Telescope
```

## 📈 **Performance Optimization**

### **1. Index Optimization**
```sql
-- Foreign key secara otomatis membuat index
-- Untuk query yang sering digunakan, tambahkan index manual jika diperlukan
```

### **2. Query Optimization**
```php
// Gunakan eager loading untuk menghindari N+1 problem
$users = User::with(['transactions', 'penyediajasa'])->get();
```

## 🎊 **Kesimpulan**

Migration database HandyGo telah dirancang untuk:
- ✅ Memperbaiki foreign key constraints yang salah
- ✅ Menambahkan relasi yang hilang
- ✅ Meningkatkan integritas data
- ✅ Mempersiapkan database untuk fitur-fitur baru
- ✅ Memastikan konsistensi struktur database

Semua migration sudah production ready dan dapat dijalankan dengan aman.
