# 🔧 Catatan Maintenance HandyGo Database & Model

## 📋 **Overview Maintenance**

Panduan maintenance untuk menjaga performa dan integritas database serta model Laravel HandyGo yang telah dioptimasi.

---

## 🔄 **Maintenance Schedule**

### **Daily Tasks (Harian)**

#### **1. Monitor System Health**
```bash
# Check application logs
tail -f storage/logs/laravel.log | grep -i error

# Monitor database connections
php artisan tinker
>>> DB::connection()->getPdo();
```

#### **2. Performance Monitoring**
```bash
# Check slow queries (if query logging enabled)
tail -f storage/logs/query.log | grep -E "([0-9]+ms|[0-9]+s)"

# Monitor memory usage
free -h
```

#### **3. Error Tracking**
```bash
# Check for relationship errors
grep -i "null" storage/logs/laravel.log
grep -i "foreign key" storage/logs/laravel.log
```

### **Weekly Tasks (Mingguan)**

#### **1. Database Integrity Check**
```sql
-- Check foreign key constraints
SELECT * FROM transactions WHERE penyedia_jasa_id NOT IN (SELECT id FROM penyedia_jasa);
SELECT * FROM notifications WHERE penyedia_jasa_id NOT IN (SELECT id FROM penyedia_jasa);
SELECT * FROM job_orders WHERE penyedia_jasa_id NOT IN (SELECT id FROM penyedia_jasa);

-- Check for orphaned records
SELECT * FROM transactions WHERE job_order_id IS NOT NULL 
    AND job_order_id NOT IN (SELECT id FROM job_orders);
```

#### **2. Performance Analysis**
```bash
# Run performance tests
php artisan tinker
>>> $start = microtime(true);
>>> User::with(['penyediajasa', 'transactions', 'jobOrders'])->take(100)->get();
>>> echo "Time: " . (microtime(true) - $start) . "s";
```

#### **3. Data Cleanup**
```sql
-- Clean up old notifications (older than 3 months)
DELETE FROM notifications WHERE created_at < DATE('now', '-3 months') AND is_read = 1;

-- Archive old transactions (if needed)
-- Consider moving old completed transactions to archive table
```

### **Monthly Tasks (Bulanan)**

#### **1. Database Optimization**
```sql
-- SQLite optimization
VACUUM;
ANALYZE;

-- MySQL optimization (if using MySQL)
-- OPTIMIZE TABLE transactions;
-- OPTIMIZE TABLE job_orders;
-- OPTIMIZE TABLE notifications;
```

#### **2. Index Analysis**
```sql
-- Check index usage (SQLite)
EXPLAIN QUERY PLAN SELECT * FROM transactions 
    JOIN penyedia_jasa ON transactions.penyedia_jasa_id = penyedia_jasa.id;

-- Consider adding indexes for frequently queried columns
CREATE INDEX IF NOT EXISTS idx_transactions_status ON transactions(status);
CREATE INDEX IF NOT EXISTS idx_job_orders_tanggal ON job_orders(tanggal_pelaksanaan);
CREATE INDEX IF NOT EXISTS idx_notifications_type ON notifications(notification_type);
```

#### **3. Model Relationship Review**
```php
// Review and test all model relationships
php artisan tinker
>>> $stats = [
    'users' => User::count(),
    'penyedia_jasa' => PenyediaJasa::count(),
    'job_orders' => JobOrder::count(),
    'transactions' => Transaction::count(),
    'notifications' => Notification::count(),
    'services' => Service::count()
];
>>> print_r($stats);
```

### **Quarterly Tasks (Triwulan)**

#### **1. Security Audit**
```bash
# Review fillable fields
grep -r "fillable" app/Models/

# Check for mass assignment vulnerabilities
grep -r "guarded" app/Models/

# Review access control in controllers
grep -r "authorize" app/Http/Controllers/
```

#### **2. Performance Audit**
```bash
# Profile heavy queries
php artisan tinker
>>> DB::enableQueryLog();
>>> User::with(['penyediajasa.transactions'])->get();
>>> dd(DB::getQueryLog());
```

#### **3. Data Growth Analysis**
```sql
-- Analyze data growth trends
SELECT 
    strftime('%Y-%m', created_at) as month,
    COUNT(*) as count
FROM transactions 
GROUP BY strftime('%Y-%m', created_at)
ORDER BY month DESC
LIMIT 12;
```

---

## ⚠️ **Common Issues & Solutions**

### **1. Foreign Key Constraint Violations**

#### **Symptoms:**
```
SQLSTATE[23000]: Integrity constraint violation: 19 FOREIGN KEY constraint failed
```

#### **Diagnosis:**
```sql
-- Find invalid references
SELECT t.id, t.penyedia_jasa_id 
FROM transactions t 
LEFT JOIN penyedia_jasa p ON t.penyedia_jasa_id = p.id 
WHERE p.id IS NULL;
```

#### **Solution:**
```sql
-- Fix invalid references (careful with this!)
UPDATE transactions 
SET penyedia_jasa_id = NULL 
WHERE penyedia_jasa_id NOT IN (SELECT id FROM penyedia_jasa);

-- Or delete invalid records
DELETE FROM transactions 
WHERE penyedia_jasa_id NOT IN (SELECT id FROM penyedia_jasa);
```

### **2. N+1 Query Problems**

#### **Symptoms:**
```
Excessive database queries (100+ queries per page)
Slow page load times
```

#### **Diagnosis:**
```php
// Enable query logging in development
DB::enableQueryLog();
// Run your code
dd(DB::getQueryLog());
```

#### **Solution:**
```php
// Use eager loading
$users = User::with(['penyediajasa', 'transactions'])->get();

// Use lazy eager loading when needed
$users = User::all();
$users->load('penyediajasa');
```

### **3. Memory Issues with Large Datasets**

#### **Symptoms:**
```
PHP Fatal error: Allowed memory size exhausted
```

#### **Solution:**
```php
// Use pagination
$transactions = Transaction::paginate(50);

// Use chunking for large operations
Transaction::chunk(1000, function($transactions) {
    foreach ($transactions as $transaction) {
        // Process transaction
    }
});

// Use lazy collections for memory efficiency
Transaction::lazy()->each(function($transaction) {
    // Process transaction
});
```

### **4. Relationship Loading Issues**

#### **Symptoms:**
```
Trying to get property 'name' of null
Call to undefined relationship
```

#### **Solution:**
```php
// Use null-safe operators
$userName = $transaction->user?->name;

// Use withDefault() for optional relationships
public function service()
{
    return $this->belongsTo(Service::class)->withDefault();
}

// Check relationship existence
if ($user->relationLoaded('penyediajasa')) {
    // Use relationship
}
```

---

## 📊 **Monitoring Metrics**

### **Key Performance Indicators (KPIs)**

#### **Database Performance:**
- Average query execution time < 50ms
- Database connection pool utilization < 80%
- Foreign key constraint violations = 0
- Deadlocks per day < 5

#### **Application Performance:**
- Memory usage per request < 30MB
- Page load time < 2 seconds
- Model relationship loading time < 100ms
- Cache hit ratio > 80%

#### **Data Quality:**
- Orphaned records = 0
- Data consistency errors = 0
- Null constraint violations = 0
- Duplicate key violations = 0

### **Monitoring Tools Setup**

#### **1. Laravel Telescope (Development)**
```bash
composer require laravel/telescope
php artisan telescope:install
php artisan migrate
```

#### **2. Query Logging**
```php
// config/database.php
'connections' => [
    'sqlite' => [
        // ...
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ],
        'log' => true,
    ],
],
```

#### **3. Custom Health Check**
```php
// app/Console/Commands/HealthCheck.php
public function handle()
{
    $checks = [
        'database_connection' => $this->checkDatabaseConnection(),
        'foreign_keys' => $this->checkForeignKeys(),
        'data_integrity' => $this->checkDataIntegrity(),
    ];
    
    $this->info(json_encode($checks, JSON_PRETTY_PRINT));
}
```

---

## 🔄 **Backup & Recovery**

### **Backup Strategy**

#### **1. Database Backup**
```bash
# SQLite backup
cp database/database.sqlite backups/database_$(date +%Y%m%d_%H%M%S).sqlite

# MySQL backup
mysqldump -u username -p database_name > backups/database_$(date +%Y%m%d_%H%M%S).sql
```

#### **2. Automated Backup Script**
```bash
#!/bin/bash
# backup.sh
BACKUP_DIR="/path/to/backups"
DATE=$(date +%Y%m%d_%H%M%S)

# Database backup
cp database/database.sqlite $BACKUP_DIR/database_$DATE.sqlite

# Keep only last 30 days
find $BACKUP_DIR -name "database_*.sqlite" -mtime +30 -delete
```

#### **3. Recovery Procedure**
```bash
# Stop application
php artisan down

# Restore database
cp backups/database_YYYYMMDD_HHMMSS.sqlite database/database.sqlite

# Verify integrity
php artisan migrate:status

# Start application
php artisan up
```

---

## 🚀 **Performance Optimization**

### **1. Database Optimization**

#### **Index Optimization:**
```sql
-- Create indexes for frequently queried columns
CREATE INDEX idx_transactions_user_id ON transactions(user_id);
CREATE INDEX idx_transactions_penyedia_jasa_id ON transactions(penyedia_jasa_id);
CREATE INDEX idx_transactions_job_order_id ON transactions(job_order_id);
CREATE INDEX idx_transactions_created_at ON transactions(created_at);

CREATE INDEX idx_job_orders_penyedia_jasa_id ON job_orders(penyedia_jasa_id);
CREATE INDEX idx_job_orders_user_id ON job_orders(user_id);
CREATE INDEX idx_job_orders_status ON job_orders(status);

CREATE INDEX idx_notifications_user_id ON notifications(user_id);
CREATE INDEX idx_notifications_is_read ON notifications(is_read);
CREATE INDEX idx_notifications_type ON notifications(notification_type);
```

#### **Query Optimization:**
```php
// Use select() to limit columns
User::select('id', 'name', 'email')->with('penyediajasa')->get();

// Use whereHas() instead of loading all relationships
$usersWithTransactions = User::whereHas('transactions')->get();

// Use raw queries for complex aggregations
DB::select('
    SELECT p.nama, COUNT(t.id) as transaction_count, SUM(t.total_amount) as total_earnings
    FROM penyedia_jasa p
    LEFT JOIN transactions t ON p.id = t.penyedia_jasa_id
    GROUP BY p.id, p.nama
    ORDER BY total_earnings DESC
');
```

### **2. Application Optimization**

#### **Caching Strategy:**
```php
// Cache expensive queries
$topProviders = Cache::remember('top_providers', 3600, function() {
    return PenyediaJasa::withCount('jobOrders')
        ->orderByDesc('job_orders_count')
        ->take(10)
        ->get();
});

// Cache user-specific data
$userNotifications = Cache::remember("user_notifications_{$userId}", 300, function() use ($userId) {
    return Notification::where('user_id', $userId)
        ->unread()
        ->orderByDesc('created_at')
        ->take(5)
        ->get();
});
```

#### **Model Optimization:**
```php
// Use lazy loading for large collections
public function getTransactionsAttribute()
{
    return $this->transactions()->lazy();
}

// Add scope methods for common queries
public function scopeActiveProviders($query)
{
    return $query->whereHas('jobOrders', function($q) {
        $q->where('created_at', '>=', now()->subMonth());
    });
}
```

---

## 📈 **Growth Planning**

### **Scaling Considerations**

#### **Database Scaling:**
- Monitor table sizes and growth rates
- Plan for partitioning large tables (transactions, notifications)
- Consider read replicas for reporting
- Implement archiving strategy for old data

#### **Application Scaling:**
- Implement queue system for heavy operations
- Add caching layers (Redis/Memcached)
- Optimize eager loading strategies
- Consider API rate limiting

#### **Monitoring Scaling:**
- Set up alerting for performance thresholds
- Monitor disk space usage
- Track query performance trends
- Monitor user growth patterns

### **Future Enhancements**

#### **1. Soft Deletes**
```php
// Add soft deletes for audit trail
use SoftDeletes;

protected $dates = ['deleted_at'];
```

#### **2. Model Observers**
```php
// Add observers for automated tasks
class TransactionObserver
{
    public function created(Transaction $transaction)
    {
        // Send notification
        // Update statistics
        // Log activity
    }
}
```

#### **3. Event Sourcing**
```php
// Consider event sourcing for audit trail
event(new TransactionCreated($transaction));
event(new JobOrderCompleted($jobOrder));
```

---

## 📞 **Emergency Contacts & Procedures**

### **Emergency Response Team**
- **Database Administrator**: [Contact Info]
- **Lead Developer**: [Contact Info]
- **System Administrator**: [Contact Info]
- **Project Manager**: [Contact Info]

### **Emergency Procedures**

#### **1. Database Corruption**
```bash
# Immediate response
php artisan down
# Restore from latest backup
# Verify data integrity
# Restart application
```

#### **2. Performance Degradation**
```bash
# Identify slow queries
# Check database locks
# Scale resources if needed
# Implement temporary fixes
```

#### **3. Data Loss**
```bash
# Stop all write operations
# Assess damage extent
# Restore from backup
# Verify data consistency
```

---

## 📝 **Documentation Updates**

### **Keep Updated:**
- ERD diagrams when schema changes
- Model relationship documentation
- API documentation if applicable
- Performance benchmarks
- Troubleshooting guides

### **Version Control:**
- Tag stable releases
- Document breaking changes
- Maintain changelog
- Update deployment guides

---

## 🎯 **Success Metrics Review**

### **Monthly Review Checklist:**
- [ ] Performance metrics within acceptable ranges
- [ ] No critical errors in logs
- [ ] Data integrity maintained
- [ ] Backup strategy working
- [ ] Documentation up to date
- [ ] Security measures effective
- [ ] User satisfaction maintained

---

**Maintenance yang konsisten akan memastikan HandyGo tetap optimal dan reliable!** 🚀

---

*Panduan maintenance ini harus diperbarui seiring dengan evolusi aplikasi.*
