<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'status',
        'image',
        'category',
        'duration_hours',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'decimal:2',
        'duration_hours' => 'integer',
    ];

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'tersedia');
    }

    /**
     * Scope untuk filter berdasarkan kategori
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Relasi: Service memiliki banyak job orders
     */
    public function jobOrders()
    {
        return $this->hasMany(JobOrder::class);
    }

    /**
     * Relasi: Service bisa dipilih oleh banyak penyedia jasa (many-to-many)
     */
    public function penyediaJasa()
    {
        return $this->belongsToMany(PenyediaJasa::class, 'penyedia_service')
            ->withPivot('custom_price', 'is_available', 'notes')
            ->withTimestamps();
    }

    /**
     * Helper method: Cek apakah service tersedia
     */
    public function isAvailable(): bool
    {
        return $this->status === 'tersedia';
    }

    /**
     * Helper method: Get formatted price
     */
    public function getFormattedPrice(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Helper method: Get service image URL
     */
    public function getImageUrl(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        return asset('images/default-service.png');
    }

    /**
     * Helper method: Get formatted duration
     */
    public function getFormattedDuration(): string
    {
        return $this->duration_hours . ' jam';
    }

    /**
     * Helper method: Get category label in Indonesian
     */
    public function getCategoryLabel(): string
    {
        $categories = [
            'kebersihan' => 'Kebersihan',
            'perbaikan' => 'Perbaikan',
            'teknologi' => 'Teknologi',
            'perawatan' => 'Perawatan',
            'transportasi' => 'Transportasi',
            'lainnya' => 'Lainnya',
        ];

        return $categories[$this->category] ?? ucfirst($this->category);
    }

    /**
     * Helper method: Get available providers for this service
     */
    public function getAvailableProviders()
    {
        return $this->penyediaJasa()
            ->wherePivot('is_available', true)
            ->whereHas('user', function ($query) {
                $query->where('status', 'aktif');
            })
            ->with('user')
            ->get();
    }
}
