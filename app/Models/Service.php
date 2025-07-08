<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_jasa',
        'kategori',
        'harga',
    ];

    /**
     * Casts untuk type casting kolom database.
     */
    protected $casts = [
        'harga' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi dengan model JobOrder melalui nama_jasa.
     * Catatan: Tidak ada service_id di job_orders, relasi berdasarkan nama_jasa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobOrders()
    {
        // Karena tidak ada service_id di job_orders, relasi berdasarkan nama_jasa
        return $this->hasMany(JobOrder::class, 'nama_jasa', 'nama_jasa');
    }

    /**
     * Relasi dengan model Transaction melalui JobOrder.
     * Catatan: Menggunakan nama_jasa sebagai penghubung
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function transactions()
    {
        // Relasi melalui nama_jasa dan job_order_id
        return $this->hasManyThrough(
            Transaction::class,
            JobOrder::class,
            'nama_jasa', // foreign key pada job_orders
            'job_order_id', // foreign key pada transactions
            'nama_jasa', // local key pada services
            'id' // local key pada job_orders
        );
    }
}
