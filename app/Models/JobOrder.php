<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobOrder extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_code',
        'user_id',
        'service_id',
        'provider_id',
        'description',
        'address',
        'customer_phone',
        'status',
        'base_price',
        'final_price',
        'admin_fee',
        'scheduled_at',
        'started_at',
        'completed_at',
        'rating',
        'review',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'base_price' => 'decimal:2',
        'final_price' => 'decimal:2',
        'admin_fee' => 'decimal:2',
        'scheduled_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'rating' => 'integer',
    ];

    /**
     * Boot method untuk generate order code
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($jobOrder) {
            if (empty($jobOrder->order_code)) {
                $jobOrder->order_code = $jobOrder->generateOrderCode();
            }
        });
    }

    /**
     * Generate unique order code
     */
    private function generateOrderCode(): string
    {
        $date = now()->format('Ymd');

        // Ambil order terakhir berdasarkan order_code, bukan created_at
        $lastOrder = static::where('order_code', 'like', 'JO-' . $date . '-%')
            ->orderBy('order_code', 'desc')
            ->first();

        $sequence = 1;
        if ($lastOrder) {
            $lastSequence = intval(substr($lastOrder->order_code, -4));
            $sequence = $lastSequence + 1;
        }

        $orderCode = 'JO-' . $date . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        // Pastikan tidak ada duplikat
        while (static::where('order_code', $orderCode)->exists()) {
            $sequence++;
            $orderCode = 'JO-' . $date . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
        }

        return $orderCode;
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk filter berdasarkan user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope untuk filter berdasarkan provider
     */
    public function scopeForProvider($query, $providerId)
    {
        return $query->where('provider_id', $providerId);
    }

    /**
     * Relasi: Job order belongs to user (customer)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Job order belongs to service
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Relasi: Job order belongs to provider (penyedia jasa)
     */
    public function provider()
    {
        return $this->belongsTo(PenyediaJasa::class, 'provider_id');
    }

    /**
     * Relasi: Job order memiliki banyak transactions
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Helper method: Cek apakah order pending
     */
    public function isPending(): bool
    {
        return $this->status === 'menunggu';
    }

    /**
     * Helper method: Cek apakah order completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'selesai';
    }

    /**
     * Helper method: Cek apakah order dalam progress
     */
    public function isInProgress(): bool
    {
        return $this->status === 'dikerjakan';
    }

    /**
     * Helper method: Get status label
     */
    public function getStatusLabel(): string
    {
        $statuses = [
            'menunggu' => 'Menunggu Provider',
            'diterima' => 'Diterima',
            'dikerjakan' => 'Sedang Dikerjakan',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
        ];

        return $statuses[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Helper method: Get status badge class
     */
    public function getStatusBadgeClass(): string
    {
        $classes = [
            'menunggu' => 'bg-warning',
            'diterima' => 'bg-info',
            'dikerjakan' => 'bg-primary',
            'selesai' => 'bg-success',
            'dibatalkan' => 'bg-danger',
        ];

        return $classes[$this->status] ?? 'bg-secondary';
    }

    /**
     * Helper method: Get formatted final price
     */
    public function getFormattedFinalPrice(): string
    {
        return 'Rp ' . number_format($this->final_price, 0, ',', '.');
    }

    /**
     * Helper method: Get total amount (final_price + admin_fee)
     */
    public function getTotalAmount(): float
    {
        return $this->final_price + $this->admin_fee;
    }

    /**
     * Helper method: Get formatted total amount
     */
    public function getFormattedTotalAmount(): string
    {
        return 'Rp ' . number_format($this->getTotalAmount(), 0, ',', '.');
    }

    /**
     * Helper method: Cek apakah bisa dibatalkan
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['menunggu', 'diterima']);
    }

    /**
     * Helper method: Cek apakah bisa dimulai
     */
    public function canBeStarted(): bool
    {
        return $this->status === 'diterima';
    }

    /**
     * Helper method: Cek apakah bisa diselesaikan
     */
    public function canBeCompleted(): bool
    {
        return $this->status === 'dikerjakan';
    }

    /**
     * Helper method: Get star rating HTML
     */
    public function getStarRating(): string
    {
        if (!$this->rating) {
            return 'Belum dinilai';
        }

        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $stars .= '★';
            } else {
                $stars .= '☆';
            }
        }

        return $stars;
    }

    /**
     * Helper method: Get duration in human readable format
     */
    public function getDurationText(): string
    {
        if (!$this->started_at || !$this->completed_at) {
            return '-';
        }

        $duration = $this->completed_at->diffInMinutes($this->started_at);

        if ($duration < 60) {
            return $duration . ' menit';
        } else {
            $hours = floor($duration / 60);
            $minutes = $duration % 60;
            return $hours . ' jam ' . ($minutes > 0 ? $minutes . ' menit' : '');
        }
    }
}