<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'pembayaran',
        'nama_pekerja',
        'waktu_kerja',
        'nama_jasa',
        'harga_penawaran',
        'tanggal_pelaksanaan',
        'waktu',
        'gender',
        'deskripsi',
        'informasi_pembayaran',
    ];
}
