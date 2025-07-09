<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_code',
        'job_order_id',
        'user_id',
        'amount',
        'admin_fee',
        'total_amount',
        'payment_method',
        'status',
        'paid_at',
        'expired_at',
        'payment_details',
        'payment_reference',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'admin_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'expired_at' => 'datetime',
        'payment_details' => 'array', // JSON field
    ];

    /**
     * Boot method untuk generate transaction code
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (empty($transaction->transaction_code)) {
                $transaction->transaction_code = $transaction->generateTransactionCode();
            }

            // Auto calculate total_amount if not set
            if (empty($transaction->total_amount)) {
                $transaction->total_amount = $transaction->amount + $transaction->admin_fee;
            }
        });
    }

    /**
     * Generate unique transaction code
     */
    private function generateTransactionCode(): string
    {
        $date = now()->format('Ymd');
        $lastTransaction = static::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastTransaction ? intval(substr($lastTransaction->transaction_code, -4)) + 1 : 1;

        return 'TRX-' . $date . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk filter berdasarkan payment method
     */
    public function scopePaymentMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }

    /**
     * Scope untuk filter berdasarkan user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Relasi: Transaction belongs to job order
     */
    public function jobOrder()
    {
        return $this->belongsTo(JobOrder::class);
    }

    /**
     * Relasi: Transaction belongs to user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper method: Cek apakah transaksi pending
     */
    public function isPending(): bool
    {
        return $this->status === 'menunggu';
    }

    /**
     * Helper method: Cek apakah transaksi sudah lunas
     */
    public function isPaid(): bool
    {
        return $this->status === 'lunas';
    }

    /**
     * Helper method: Cek apakah transaksi gagal
     */
    public function isFailed(): bool
    {
        return $this->status === 'gagal';
    }

    /**
     * Helper method: Cek apakah transaksi kadaluarsa
     */
    public function isExpired(): bool
    {
        return $this->status === 'kadaluarsa' ||
            ($this->expired_at && $this->expired_at->isPast() && $this->isPending());
    }

    /**
     * Helper method: Get status label
     */
    public function getStatusLabel(): string
    {
        $statuses = [
            'menunggu' => 'Menunggu Pembayaran',
            'lunas' => 'Lunas',
            'gagal' => 'Gagal',
            'dikembalikan' => 'Dikembalikan',
            'kadaluarsa' => 'Kadaluarsa',
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
            'lunas' => 'bg-success',
            'gagal' => 'bg-danger',
            'dikembalikan' => 'bg-info',
            'kadaluarsa' => 'bg-secondary',
        ];

        return $classes[$this->status] ?? 'bg-secondary';
    }

    /**
     * Helper method: Get payment method label
     */
    public function getPaymentMethodLabel(): string
    {
        $methods = [
            'tunai' => 'Tunai',
            'transfer_bank' => 'Transfer Bank',
            'dompet_digital' => 'Dompet Digital',
            'qris' => 'QRIS',
        ];

        return $methods[$this->payment_method] ?? ucfirst($this->payment_method);
    }

    /**
     * Helper method: Get formatted total amount
     */
    public function getFormattedTotalAmount(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    /**
     * Helper method: Get formatted amount
     */
    public function getFormattedAmount(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    /**
     * Helper method: Get formatted admin fee
     */
    public function getFormattedAdminFee(): string
    {
        return 'Rp ' . number_format($this->admin_fee, 0, ',', '.');
    }

    /**
     * Helper method: Get remaining time for payment
     */
    public function getRemainingTime(): ?string
    {
        if (!$this->expired_at || !$this->isPending()) {
            return null;
        }

        if ($this->isExpired()) {
            return 'Kadaluarsa';
        }

        $diff = now()->diffInMinutes($this->expired_at);

        if ($diff < 60) {
            return $diff . ' menit';
        } else {
            $hours = floor($diff / 60);
            $minutes = $diff % 60;
            return $hours . ' jam ' . ($minutes > 0 ? $minutes . ' menit' : '');
        }
    }

    /**
     * Helper method: Mark as paid
     */
    public function markAsPaid($paymentReference = null): bool
    {
        $this->status = 'lunas';
        $this->paid_at = now();

        if ($paymentReference) {
            $this->payment_reference = $paymentReference;
        }

        return $this->save();
    }

    /**
     * Helper method: Mark as failed
     */
    public function markAsFailed($reason = null): bool
    {
        $this->status = 'gagal';

        if ($reason) {
            $details = $this->payment_details ?? [];
            $details['failure_reason'] = $reason;
            $this->payment_details = $details;
        }

        return $this->save();
    }

    /**
     * Helper method: Mark as expired
     */
    public function markAsExpired(): bool
    {
        if ($this->isPending()) {
            $this->status = 'kadaluarsa';
            return $this->save();
        }

        return false;
    }
}