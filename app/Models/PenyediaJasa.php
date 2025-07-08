<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenyediaJasa extends Model
{
    protected $table = "penyedia_jasa";

    protected $fillable = [
        'nama',
        'foto',
        'user_id',
        'email',
        'telpon',
        'gender',
        'alamat',
        'tanggal_lahir',
    ];

    /**
     * Casts untuk type casting kolom database.
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi dengan model JobOrder.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobOrders()
    {
        return $this->hasMany(JobOrder::class, 'penyedia_jasa_id');
    }

    /**
     * Relasi dengan model User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi dengan model Transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'penyedia_jasa_id');
    }

    /**
     * Relasi dengan model Notification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'penyedia_jasa_id');
    }
}
