# 🔗 Dokumentasi Relasi Model Laravel HandyGo

## 📋 **Overview Relasi**

Dokumentasi lengkap relasi antar model dalam aplikasi HandyGo yang telah dioptimasi sesuai dengan best practices Laravel dan konsistensi database schema.

---

## 🏗️ **Struktur Relasi Utama**

### **1. User Model (app/Models/User.php)**

#### **Relasi yang Dimiliki:**
```php
// One-to-One Relationship
public function penyediajasa()
{
    return $this->hasOne(PenyediaJasa::class, 'user_id');
}

// One-to-Many Relationships sebagai Customer
public function transactions()
{
    return $this->hasMany(Transaction::class, 'user_id');
}

public function notifications()
{
    return $this->hasMany(Notification::class, 'user_id');
}

public function jobOrders()
{
    return $this->hasMany(JobOrder::class, 'user_id');
}
```

#### **Cara Penggunaan:**
```php
$user = User::find(1);

// Akses penyedia jasa profile (jika ada)
$providerProfile = $user->penyediajasa;

// Akses semua transaksi sebagai customer
$customerTransactions = $user->transactions;

// Akses notifikasi yang diterima
$notifications = $user->notifications;

// Akses job orders yang dibuat
$jobOrders = $user->jobOrders;
```

---

### **2. PenyediaJasa Model (app/Models/PenyediaJasa.php)**

#### **Relasi yang Dimiliki:**
```php
// Belongs-to Relationship
public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

// One-to-Many Relationships sebagai Provider
public function jobOrders()
{
    return $this->hasMany(JobOrder::class, 'penyedia_jasa_id');
}

public function transactions()
{
    return $this->hasMany(Transaction::class, 'penyedia_jasa_id');
}

public function notifications()
{
    return $this->hasMany(Notification::class, 'penyedia_jasa_id');
}
```

#### **Casting Fields:**
```php
protected $casts = [
    'tanggal_lahir' => 'date',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
];
```

#### **Cara Penggunaan:**
```php
$provider = PenyediaJasa::find(1);

// Akses user yang terkait
$user = $provider->user;

// Akses job orders yang dikerjakan
$workedJobs = $provider->jobOrders;

// Akses transaksi sebagai provider
$earnings = $provider->transactions;

// Akses notifikasi yang diterima
$notifications = $provider->notifications;
```

---

### **3. Service Model (app/Models/Service.php)**

#### **Relasi yang Dimiliki:**
```php
// One-to-Many melalui nama_jasa (bukan service_id)
public function jobOrders()
{
    return $this->hasMany(JobOrder::class, 'nama_jasa', 'nama_jasa');
}

// Has-Many-Through Relationship
public function transactions()
{
    return $this->hasManyThrough(
        Transaction::class, 
        JobOrder::class, 
        'nama_jasa', // foreign key pada job_orders
        'job_order_id', // foreign key pada transactions
        'nama_jasa', // local key pada services
        'id' // local key pada job_orders
    );
}
```

#### **Casting Fields:**
```php
protected $casts = [
    'harga' => 'decimal:2',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
];
```

#### **Cara Penggunaan:**
```php
$service = Service::find(1);

// Akses job orders yang menggunakan service ini
$relatedJobs = $service->jobOrders;

// Akses transaksi melalui job orders
$relatedTransactions = $service->transactions;

// Query dengan eager loading
$servicesWithJobs = Service::with('jobOrders')->get();
```

---

### **4. JobOrder Model (app/Models/JobOrder.php)**

#### **Relasi yang Dimiliki:**
```php
// Belongs-to Relationships
public function user()
{
    return $this->belongsTo(User::class);
}

public function penyediajasa()
{
    return $this->belongsTo(PenyediaJasa::class, 'penyedia_jasa_id');
}

// Service relationship dengan withDefault
public function service()
{
    return $this->belongsTo(Service::class, 'service_id')->withDefault();
}

// One-to-Many Relationship
public function transactions()
{
    return $this->hasMany(Transaction::class, 'job_order_id');
}
```

#### **Casting Fields:**
```php
protected $casts = [
    'tanggal_pelaksanaan' => 'date',
    'harga_penawaran' => 'decimal:2',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
];
```

#### **Cara Penggunaan:**
```php
$jobOrder = JobOrder::find(1);

// Akses customer yang memesan
$customer = $jobOrder->user;

// Akses provider yang mengerjakan
$provider = $jobOrder->penyediajasa;

// Akses service terkait (dengan default jika null)
$service = $jobOrder->service;

// Akses transaksi untuk job ini
$payments = $jobOrder->transactions;
```

---

### **5. Transaction Model (app/Models/Transaction.php)**

#### **Relasi yang Dimiliki:**
```php
// Belongs-to Relationships
public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function penyediaJasa()
{
    return $this->belongsTo(PenyediaJasa::class, 'penyedia_jasa_id');
}

public function jobOrder()
{
    return $this->belongsTo(JobOrder::class, 'job_order_id');
}
```

#### **Casting Fields:**
```php
protected $casts = [
    'tanggal' => 'date',
    'total_amount' => 'decimal:2',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
];
```

#### **Cara Penggunaan:**
```php
$transaction = Transaction::find(1);

// Akses customer yang bayar
$customer = $transaction->user;

// Akses provider yang menerima
$provider = $transaction->penyediaJasa;

// Akses job order terkait
$jobOrder = $transaction->jobOrder;

// Akses dengan eager loading
$transactionsWithAll = Transaction::with(['user', 'penyediaJasa', 'jobOrder'])->get();
```

---

### **6. Notification Model (app/Models/Notification.php)**

#### **Relasi yang Dimiliki:**
```php
// Belongs-to Relationships
public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function penyediaJasa()
{
    return $this->belongsTo(PenyediaJasa::class, 'penyedia_jasa_id');
}
```

#### **Scope Methods:**
```php
// Filter notifikasi yang belum dibaca
public function scopeUnread($query)
{
    return $query->where('is_read', false);
}

// Filter berdasarkan tipe notifikasi
public function scopeOfType($query, $type)
{
    return $query->where('notification_type', $type);
}

// Filter berdasarkan status
public function scopeByStatus($query, $status)
{
    return $query->where('status', $status);
}
```

#### **Helper Methods:**
```php
// Mark sebagai sudah dibaca
public function markAsRead()
{
    return $this->update(['is_read' => true]);
}

// Mark sebagai belum dibaca
public function markAsUnread()
{
    return $this->update(['is_read' => false]);
}
```

#### **Casting Fields:**
```php
protected $casts = [
    'is_read' => 'boolean',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
];
```

#### **Cara Penggunaan:**
```php
$notification = Notification::find(1);

// Akses user penerima
$recipient = $notification->user;

// Akses provider terkait
$provider = $notification->penyediaJasa;

// Menggunakan scope
$unreadNotifications = Notification::unread()->get();
$systemNotifications = Notification::ofType('system')->get();

// Menggunakan helper methods
$notification->markAsRead();
$notification->markAsUnread();
```

---

## 🎯 **Contoh Query Kompleks**

### **1. Eager Loading dengan Multiple Relationships**
```php
// Load user dengan semua relasinya
$userWithAll = User::with([
    'penyediajasa',
    'transactions.penyediaJasa',
    'jobOrders.penyediajasa',
    'notifications.penyediaJasa'
])->find(1);

// Load provider dengan earnings dan jobs
$providerWithEarnings = PenyediaJasa::with([
    'user',
    'transactions.jobOrder',
    'jobOrders.user'
])->find(1);
```

### **2. Query dengan Kondisi Relasi**
```php
// User yang memiliki transaksi dengan status tertentu
$usersWithPaidTransactions = User::whereHas('transactions', function($query) {
    $query->where('status', 'completed');
})->get();

// Provider yang memiliki rating tinggi (jika ada field rating)
$topProviders = PenyediaJasa::whereHas('jobOrders', function($query) {
    $query->where('status', 'completed');
}, '>=', 5)->get();
```

### **3. Aggregate Queries**
```php
// Total earnings per provider
$providerEarnings = PenyediaJasa::withSum('transactions', 'total_amount')->get();

// Count jobs per provider
$providerJobCount = PenyediaJasa::withCount('jobOrders')->get();

// Provider dengan transaksi terbanyak
$topEarners = PenyediaJasa::withSum('transactions', 'total_amount')
    ->orderByDesc('transactions_sum_total_amount')
    ->take(10)
    ->get();
```

---

## ⚠️ **Catatan Penting**

### **1. Service-JobOrder Relationship**
- **Tidak menggunakan `service_id`** karena field ini tidak ada di database
- **Menggunakan `nama_jasa`** sebagai penghubung
- Relasi bersifat optional dengan `withDefault()`

### **2. Performance Considerations**
```php
// Gunakan eager loading untuk menghindari N+1 problem
$users = User::with('transactions')->get();

// Gunakan pagination untuk data besar
$transactions = Transaction::with(['user', 'penyediaJasa'])->paginate(20);
```

### **3. Validation di Model Level**
```php
// Tambahkan custom validation jika diperlukan
public function save(array $options = [])
{
    // Custom validation logic
    parent::save($options);
}
```

---

## 🚀 **Best Practices**

### **1. Consistent Naming**
- Method names menggunakan camelCase
- Relationship names descriptive dan konsisten
- Foreign key names sesuai konvensi Laravel

### **2. Type Safety**
- Gunakan casting untuk field dates dan decimals
- Return type hints untuk methods
- Nullable relationships dengan withDefault()

### **3. Performance**
- Eager loading untuk multiple relationships
- Pagination untuk large datasets
- Index pada foreign key columns

### **4. Maintainability**
- Scope methods untuk query yang sering digunakan
- Helper methods untuk operasi umum
- Clear documentation untuk complex relationships

---

**Model relationships HandyGo telah dioptimasi dan siap untuk production!** 🎊
