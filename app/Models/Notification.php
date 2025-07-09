<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'data',
        'read_at',
        'is_pushed',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array', // JSON field
        'read_at' => 'datetime',
        'is_pushed' => 'boolean',
    ];

    /**
     * Scope untuk filter notifikasi yang belum dibaca
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope untuk filter notifikasi yang sudah dibaca
     */
    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    /**
     * Scope untuk filter berdasarkan type
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope untuk filter berdasarkan user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Relasi: Notification belongs to user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper method: Cek apakah notifikasi sudah dibaca
     */
    public function isRead(): bool
    {
        return !is_null($this->read_at);
    }

    /**
     * Helper method: Cek apakah notifikasi belum dibaca
     */
    public function isUnread(): bool
    {
        return is_null($this->read_at);
    }

    /**
     * Helper method: Mark notification as read
     */
    public function markAsRead(): bool
    {
        if ($this->isUnread()) {
            $this->read_at = now();
            return $this->save();
        }

        return true;
    }

    /**
     * Helper method: Mark notification as unread
     */
    public function markAsUnread(): bool
    {
        if ($this->isRead()) {
            $this->read_at = null;
            return $this->save();
        }

        return true;
    }

    /**
     * Helper method: Get type label
     */
    public function getTypeLabel(): string
    {
        $types = [
            'informasi' => 'Informasi',
            'peringatan' => 'Peringatan',
            'berhasil' => 'Berhasil',
            'error' => 'Error',
            'update_pesanan' => 'Update Pesanan',
            'update_pembayaran' => 'Update Pembayaran',
        ];

        return $types[$this->type] ?? ucfirst($this->type);
    }

    /**
     * Helper method: Get type icon class
     */
    public function getTypeIconClass(): string
    {
        $icons = [
            'informasi' => 'bi-info-circle text-info',
            'peringatan' => 'bi-exclamation-triangle text-warning',
            'berhasil' => 'bi-check-circle text-success',
            'error' => 'bi-x-circle text-danger',
            'update_pesanan' => 'bi-cart-check text-primary',
            'update_pembayaran' => 'bi-credit-card text-success',
        ];

        return $icons[$this->type] ?? 'bi-bell text-secondary';
    }

    /**
     * Helper method: Get time ago text
     */
    public function getTimeAgo(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Helper method: Get related job order if exists
     */
    public function getRelatedJobOrder(): ?JobOrder
    {
        if ($this->data && isset($this->data['job_order_id'])) {
            return JobOrder::find($this->data['job_order_id']);
        }

        return null;
    }

    /**
     * Helper method: Get related transaction if exists
     */
    public function getRelatedTransaction(): ?Transaction
    {
        if ($this->data && isset($this->data['transaction_id'])) {
            return Transaction::find($this->data['transaction_id']);
        }

        return null;
    }

    /**
     * Static method: Create job order notification
     */
    public static function createJobOrderNotification($userId, $jobOrder, $message, $type = 'update_pesanan')
    {
        return static::create([
            'user_id' => $userId,
            'title' => 'Update Pesanan #' . $jobOrder->order_code,
            'message' => $message,
            'type' => $type,
            'data' => [
                'job_order_id' => $jobOrder->id,
                'order_code' => $jobOrder->order_code,
            ],
        ]);
    }

    /**
     * Static method: Create payment notification
     */
    public static function createPaymentNotification($userId, $transaction, $message, $type = 'update_pembayaran')
    {
        return static::create([
            'user_id' => $userId,
            'title' => 'Update Pembayaran #' . $transaction->transaction_code,
            'message' => $message,
            'type' => $type,
            'data' => [
                'transaction_id' => $transaction->id,
                'transaction_code' => $transaction->transaction_code,
                'job_order_id' => $transaction->job_order_id,
            ],
        ]);
    }

    /**
     * Static method: Create general notification
     */
    public static function createGeneralNotification($userId, $title, $message, $type = 'informasi', $data = null)
    {
        return static::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'data' => $data,
        ]);
    }

    /**
     * Static method: Mark all notifications as read for a user
     */
    public static function markAllAsReadForUser($userId): int
    {
        return static::where('user_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    /**
     * Static method: Get unread count for a user
     */
    public static function getUnreadCountForUser($userId): int
    {
        return static::where('user_id', $userId)
            ->whereNull('read_at')
            ->count();
    }
}
