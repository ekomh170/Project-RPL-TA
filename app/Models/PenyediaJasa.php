<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenyediaJasa extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'verification_status',
        'verification_documents',
        'experience',
        'rating_average',
        'total_reviews',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'rating_average' => 'decimal:2',
        'total_reviews' => 'integer',
        'verification_documents' => 'array', // JSON field
    ];

    /**
     * Scope untuk filter berdasarkan status verifikasi
     */
    public function scopeVerified($query)
    {
        return $query->where('verification_status', 'verified');
    }

    /**
     * Scope untuk filter berdasarkan rating
     */
    public function scopeHighRated($query, $minRating = 4.0)
    {
        return $query->where('rating_average', '>=', $minRating);
    }

    /**
     * Relasi: Penyedia jasa belongs to user (one-to-one)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Penyedia jasa bisa mengambil banyak job orders
     */
    public function jobOrders()
    {
        return $this->hasMany(JobOrder::class, 'provider_id');
    }

    /**
     * Relasi: Penyedia jasa bisa menyediakan banyak services (many-to-many)
     */
    public function services()
    {
        return $this->belongsToMany(Service::class, 'penyedia_service')
            ->withPivot('custom_price', 'is_available', 'notes')
            ->withTimestamps();
    }

    /**
     * Helper method: Cek apakah penyedia jasa sudah diverifikasi
     */
    public function isVerified(): bool
    {
        return $this->verification_status === 'verified';
    }

    /**
     * Helper method: Cek apakah penyedia jasa pending
     */
    public function isPending(): bool
    {
        return $this->verification_status === 'pending';
    }

    /**
     * Helper method: Get formatted rating
     */
    public function getFormattedRating(): string
    {
        return number_format($this->rating_average, 1) . '/5.0';
    }

    /**
     * Helper method: Get star rating HTML
     */
    public function getStarRating(): string
    {
        $rating = round($this->rating_average);
        $stars = '';

        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                $stars .= '★';
            } else {
                $stars .= '☆';
            }
        }

        return $stars;
    }

    /**
     * Helper method: Get verification status label
     */
    public function getVerificationStatusLabel(): string
    {
        $statuses = [
            'pending' => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
        ];

        return $statuses[$this->verification_status] ?? ucfirst($this->verification_status);
    }

    /**
     * Helper method: Get completed jobs count
     */
    public function getCompletedJobsCount(): int
    {
        return $this->jobOrders()->where('status', 'selesai')->count();
    }

    /**
     * Helper method: Update rating average
     */
    public function updateRatingAverage()
    {
        $completedJobs = $this->jobOrders()
            ->where('status', 'selesai')
            ->whereNotNull('rating')
            ->get();

        if ($completedJobs->count() > 0) {
            $this->rating_average = $completedJobs->avg('rating');
            $this->total_reviews = $completedJobs->count();
            $this->save();
        }
    }

    /**
     * Helper method: Get available services
     */
    public function getAvailableServices()
    {
        return $this->services()
            ->wherePivot('is_available', true)
            ->where('status', 'tersedia')
            ->get();
    }

    /**
     * Helper method: Get custom price for a service
     */
    public function getCustomPrice($serviceId)
    {
        $pivot = $this->services()->wherePivot('service_id', $serviceId)->first();

        if ($pivot && $pivot->pivot->custom_price) {
            return $pivot->pivot->custom_price;
        }

        $service = Service::find($serviceId);
        return $service ? $service->price : 0;
    }
}
