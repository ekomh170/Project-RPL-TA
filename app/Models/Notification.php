<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'penyedia_jasa_id',
        'pesan',
        'status',
        'notification_type', // New field for notification categorization
        'is_read', // New field for read status
    ];

    /**
     * Casts untuk type casting kolom database.
     */
    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi dengan model User (recipient).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi dengan model PenyediaJasa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function penyediaJasa()
    {
        return $this->belongsTo(PenyediaJasa::class, 'penyedia_jasa_id');
    }

    /**
     * Scope untuk notification yang belum dibaca.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope untuk notification berdasarkan tipe.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('notification_type', $type);
    }

    /**
     * Scope untuk notification berdasarkan status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Mark notification sebagai sudah dibaca.
     *
     * @return bool
     */
    public function markAsRead()
    {
        return $this->update(['is_read' => true]);
    }

    /**
     * Mark notification sebagai belum dibaca.
     *
     * @return bool
     */
    public function markAsUnread()
    {
        return $this->update(['is_read' => false]);
    }
}
