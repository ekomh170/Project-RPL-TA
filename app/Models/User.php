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
     * Relasi dengan model Transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    /**
     * Relasi dengan model Notification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    /**
     * Relasi dengan model Transaction sebagai penyedia jasa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function providedTransactions()
    {
        return $this->hasMany(Transaction::class, 'penyedia_jasa_id');
    }

   
    public function joborder()
    {
        return $this->hasMany(JobOrder::class, 'user_id');
    }

    public function penyediajasa()
    {
        return $this->hasOne(User::class, 'user_id');
    }
}
