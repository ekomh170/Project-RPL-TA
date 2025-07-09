<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'status',
        'address',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Scope untuk filter berdasarkan role
     */
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk filter user aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope untuk filter pengguna (customers)
     */
    public function scopePengguna($query)
    {
        return $query->where('role', 'pengguna');
    }

    /**
     * Scope untuk filter penyedia jasa
     */
    public function scopePenyediaJasa($query)
    {
        return $query->where('role', 'penyedia_jasa');
    }

    /**
     * Relasi: User bisa memiliki satu profil penyedia jasa
     */
    public function penyediaJasa()
    {
        return $this->hasOne(PenyediaJasa::class);
    }

    /**
     * Relasi: User memiliki banyak job orders (sebagai customer)
     */
    public function jobOrders()
    {
        return $this->hasMany(JobOrder::class);
    }

    /**
     * Relasi: User memiliki banyak transactions
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Relasi: User memiliki banyak notifications
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Helper method: Cek apakah user adalah pengguna (customer)
     */
    public function isPengguna(): bool
    {
        return $this->role === 'pengguna';
    }

    /**
     * Helper method: Cek apakah user adalah penyedia jasa
     */
    public function isPenyediaJasa(): bool
    {
        return $this->role === 'penyedia_jasa';
    }

    /**
     * Helper method: Cek apakah user aktif
     */
    public function isActive(): bool
    {
        return $this->status === 'aktif';
    }

    /**
     * Helper method: Cek apakah user pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Helper method: Cek apakah user nonaktif
     */
    public function isInactive(): bool
    {
        return $this->status === 'nonaktif';
    }

    /**
     * Helper method: Get role label
     */
    public function getRoleLabel(): string
    {
        $roles = [
            'pengguna' => 'Pengguna',
            'penyedia_jasa' => 'Penyedia Jasa',
        ];

        return $roles[$this->role] ?? ucfirst($this->role);
    }

    /**
     * Helper method: Get status label
     */
    public function getStatusLabel(): string
    {
        $statuses = [
            'pending' => 'Menunggu Aktivasi',
            'aktif' => 'Aktif',
            'nonaktif' => 'Nonaktif',
        ];

        return $statuses[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Helper method: Get status badge class
     */
    public function getStatusBadgeClass(): string
    {
        $classes = [
            'pending' => 'bg-warning',
            'aktif' => 'bg-success',
            'nonaktif' => 'bg-danger',
        ];

        return $classes[$this->status] ?? 'bg-secondary';
    }

    /**
     * Helper method: Get avatar URL
     */
    public function getAvatarUrl(): string
    {
        if ($this->profile_picture) {
            return asset('storage/' . $this->profile_picture);
        }

        // Generate avatar based on initials
        $name = trim($this->name);
        $initials = '';

        if ($name) {
            $names = explode(' ', $name);
            $initials = strtoupper(substr($names[0], 0, 1));
            if (count($names) > 1) {
                $initials .= strtoupper(substr($names[count($names) - 1], 0, 1));
            }
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($initials) . '&background=random&color=ffffff&size=150';
    }

    /**
     * Helper method: Get initials
     */
    public function getInitials(): string
    {
        $name = trim($this->name);
        $initials = '';

        if ($name) {
            $names = explode(' ', $name);
            $initials = strtoupper(substr($names[0], 0, 1));
            if (count($names) > 1) {
                $initials .= strtoupper(substr($names[count($names) - 1], 0, 1));
            }
        }

        return $initials;
    }

    /**
     * Helper method: Get unread notifications count
     */
    public function getUnreadNotificationsCount(): int
    {
        return $this->notifications()->whereNull('read_at')->count();
    }

    /**
     * Helper method: Get recent notifications
     */
    public function getRecentNotifications($limit = 5)
    {
        return $this->notifications()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Helper method: Get completed orders count (for customers)
     */
    public function getCompletedOrdersCount(): int
    {
        return $this->jobOrders()->where('status', 'selesai')->count();
    }

    /**
     * Helper method: Get total spent amount (for customers)
     */
    public function getTotalSpentAmount(): float
    {
        return $this->transactions()
            ->where('status', 'lunas')
            ->sum('total_amount');
    }

    /**
     * Helper method: Get formatted total spent
     */
    public function getFormattedTotalSpent(): string
    {
        return 'Rp ' . number_format($this->getTotalSpentAmount(), 0, ',', '.');
    }

    /**
     * Helper method: Activate user account
     */
    public function activate(): bool
    {
        $this->status = 'aktif';
        return $this->save();
    }

    /**
     * Helper method: Deactivate user account
     */
    public function deactivate(): bool
    {
        $this->status = 'nonaktif';
        return $this->save();
    }
}
