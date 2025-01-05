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
        'nama_pekerja',
        'waktu_kerja',
        'nama_jasa',
        'harga_penawaran',
        'tanggal_pelaksanaan',
        'gender',
        'deskripsi',
        'informasi_pembayaran',
    ];

    public function penyediajasa()
    {
        return $this->belongsTo(PenyediaJasa::class, 'nama_pekerja');
    }
    public function user()
    {
        return $this->belongsTo(User::class); 
    }
}
