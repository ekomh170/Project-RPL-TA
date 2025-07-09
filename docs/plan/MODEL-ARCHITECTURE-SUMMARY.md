# Model Architecture Summary - HandyGo

## Clean Model Structure

After the database audit and refactoring, we now have a clean, maintainable model architecture aligned with the new migration structure.

### Core Models (6 Total)

#### 1. User Model (`app/Models/User.php`)
- **Purpose**: Core user authentication and profile management
- **Table**: `users`
- **Key Features**:
  - Extends `Authenticatable` for Laravel auth
  - Supports both `pengguna` (customer) and `penyedia_jasa` (service provider) roles
  - Status management: `pending`, `aktif`, `nonaktif`
  - Soft deletes enabled
  - Profile picture and avatar generation
  - Comprehensive helper methods for role/status checks

**Relationships**:
- `hasOne`: PenyediaJasa (for service providers)
- `hasMany`: JobOrder, Transaction, Notification

#### 2. Service Model (`app/Models/Service.php`)
- **Purpose**: Service catalog management
- **Table**: `services`
- **Key Features**:
  - Service categories: `kebersihan`, `perbaikan`, `teknologi`, `perawatan`, `transportasi`, `lainnya`
  - Price management with decimal casting
  - Duration tracking in hours
  - Image handling with default fallback
  - Availability status tracking
  - Soft deletes enabled

**Relationships**:
- `hasMany`: JobOrder
- `belongsToMany`: PenyediaJasa (via `penyedia_service` pivot)

#### 3. PenyediaJasa Model (`app/Models/PenyediaJasa.php`)
- **Purpose**: Service provider profile and verification management
- **Table**: `penyedia_jasa`
- **Key Features**:
  - Verification system: `pending`, `verified`, `rejected`
  - Rating and review aggregation
  - Experience tracking
  - Document verification support
  - Performance metrics calculation
  - Soft deletes enabled

**Relationships**:
- `belongsTo`: User (one-to-one)
- `hasMany`: JobOrder (as provider)
- `belongsToMany`: Service (via `penyedia_service` pivot)

#### 4. JobOrder Model (`app/Models/JobOrder.php`)
- **Purpose**: Order management and workflow tracking
- **Table**: `job_orders`
- **Key Features**:
  - Auto-generating unique order codes (`JO-YYYYMMDD-XXXX`)
  - Status workflow: `menunggu`, `diterima`, `dikerjakan`, `selesai`, `dibatalkan`
  - Pricing with base and final amounts
  - Scheduling with timestamps
  - Rating and review system
  - Comprehensive status helpers
  - Soft deletes enabled

**Relationships**:
- `belongsTo`: User (customer), Service, PenyediaJasa (provider)
- `hasMany`: Transaction

#### 5. Transaction Model (`app/Models/Transaction.php`)
- **Purpose**: Payment and financial transaction management
- **Table**: `transactions`
- **Key Features**:
  - Auto-generating transaction codes (`TRX-YYYYMMDD-XXXX`)
  - Multiple payment methods: `tunai`, `transfer_bank`, `dompet_digital`, `qris`
  - Status tracking: `menunggu`, `lunas`, `gagal`, `dikembalikan`, `kadaluarsa`
  - Payment gateway integration support
  - Expiration handling
  - Fee calculation (admin_fee + amount = total_amount)
  - Soft deletes enabled

**Relationships**:
- `belongsTo`: JobOrder, User

#### 6. Notification Model (`app/Models/Notification.php`)
- **Purpose**: User notification system
- **Table**: `notifications`
- **Key Features**:
  - Multiple notification types: `informasi`, `peringatan`, `berhasil`, `error`, `update_pesanan`, `update_pembayaran`
  - Read/unread status tracking
  - JSON data field for additional context
  - Push notification support tracking
  - Factory methods for common notification types
  - Bulk operations for user notifications
  - Soft deletes enabled

**Relationships**:
- `belongsTo`: User

### Pivot Table Handling

#### penyedia_service (Pivot Table)
- **Purpose**: Many-to-many relationship between PenyediaJasa and Service
- **Extra Columns**: `custom_price`, `is_available`, `notes`
- **Implementation**: Handled through Eloquent's `belongsToMany` with `withPivot()`
- **No dedicated model needed**: Standard pivot functionality is sufficient

### Key Design Decisions

1. **No Unused Models**: All 6 models are actively used by controllers
2. **Consistent Naming**: All models follow new migration field naming (Indonesian language)
3. **Proper Relationships**: All foreign key relationships properly defined
4. **Helper Methods**: Comprehensive helper methods for business logic
5. **Scopes**: Query scopes for common filters
6. **Casts**: Proper data type casting for dates, decimals, JSON
7. **Soft Deletes**: Enabled on all main models for data integrity
8. **Auto-Generation**: Unique codes for JobOrder and Transaction

### Model Dependencies

```
User
├── PenyediaJasa (1:1)
├── JobOrder (1:many)
├── Transaction (1:many)
└── Notification (1:many)

Service
├── JobOrder (1:many)
└── PenyediaJasa (many:many via pivot)

PenyediaJasa
├── User (belongs to 1)
├── JobOrder (1:many as provider)
└── Service (many:many via pivot)

JobOrder
├── User (belongs to 1)
├── Service (belongs to 1)
├── PenyediaJasa (belongs to 1)
└── Transaction (1:many)

Transaction
├── JobOrder (belongs to 1)
└── User (belongs to 1)

Notification
└── User (belongs to 1)
```

### Migration Alignment

All models are fully aligned with the new migration structure:
- ✅ Field names match migration columns
- ✅ Data types properly cast
- ✅ Relationships match foreign keys
- ✅ Constraints and indexes supported
- ✅ Enum values match migration definitions

### Controller Compatibility Note

⚠️ **Important**: Some controllers still use old field names and need to be updated to work with the new model structure. The models themselves are clean and ready for use.

This completes the model refactoring phase of the HandyGo database architecture optimization.
