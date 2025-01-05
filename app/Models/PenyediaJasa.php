<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenyediaJasa extends Model
{
    protected $table = "penyedia_jasa";

    protected $fillable = [
        'nama',
        'user_id',
        'email',
        'telpon',
        'gender',
        'alamat',
        'tanggal_lahir',
        'foto'
    ];


    public function joborder()
    {
        return $this->hasMany(JobOrder::class, 'nama_pekerja');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
