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
        'metode_pembayaran',
        'tanggal',
        'tipe',
        'status',
        'bukti',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function penyediaJasa()
    {
        return $this->belongsTo(User::class, 'penyedia_jasa_id');
    }
}
