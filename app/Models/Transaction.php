<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'penyedia_jasa_id',
        'job_order_id', // New field for job order relation
        'metode_pembayaran',
        'tanggal',
        'tipe',
        'status',
        'bukti',
        'total_amount', // New field for amount tracking
    ];

    /**
     * Casts untuk type casting kolom database.
     */
    protected $casts = [
        'tanggal' => 'date',
        'total_amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi dengan model User (customer).
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
     * Relasi dengan model JobOrder.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jobOrder()
    {
        return $this->belongsTo(JobOrder::class, 'job_order_id');
    }
}
