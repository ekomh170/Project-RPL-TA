<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'pembayaran',
        'user_id',
        'penyedia_jasa_id',
        // 'service_id', // Field ini tidak ada di tabel database
        'waktu_kerja',
        'nama_jasa',
        'harga_penawaran',
        'tanggal_pelaksanaan',
        'gender',
        'deskripsi',
        'informasi_pembayaran',
        'nomor_telepon', // Field yang ada di database tapi tidak di fillable
        'bukti', // Field yang ada di database tapi tidak di fillable
        'status', // Field yang ada di database tapi tidak di fillable
    ];

    /**
     * Casts untuk type casting kolom database.
     */
    protected $casts = [
        'tanggal_pelaksanaan' => 'date',
        'harga_penawaran' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi dengan model PenyediaJasa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function penyediajasa()
    {
        return $this->belongsTo(PenyediaJasa::class, 'penyedia_jasa_id');
    }

    /**
     * Relasi dengan model User (customer).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi dengan model Service.
     * Catatan: Field service_id tidak ada di database, relasi melalui nama_jasa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|null
     */
    public function service()
    {
        // Karena service_id tidak ada di database, kita cari berdasarkan nama_jasa
        return $this->belongsTo(Service::class, 'service_id')->withDefault();
    }

    /**
     * Relasi dengan model Transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'job_order_id');
    }
}
