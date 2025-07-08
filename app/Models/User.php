<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'nomor_wa',
        'alamat_lengkap',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relasi dengan model Transaction sebagai customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    /**
     * Relasi dengan model Notification sebagai recipient.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    /**
     * Relasi dengan model JobOrder sebagai customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobOrders()
    {
        return $this->hasMany(JobOrder::class, 'user_id');
    }

    /**
     * Relasi dengan model PenyediaJasa (one-to-one).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function penyediajasa()
    {
        return $this->hasOne(PenyediaJasa::class, 'user_id');
    }
}
