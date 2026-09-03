<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organizer_id',
        'user_id',
        'category_id',
        'event_type_id',
        'event_format_id',
        'city_id',
        'title',
        'slug',
        'description',
        'banner',
        'event_type',
        'payment_method',
        'payment_info',
        'city',
        'location',
        'address',
        'online_url',
        'start_at',
        'end_at',
        'timezone',
        'capacity',
        'registration_deadline',
        'status',
        'rejection_reason',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'registration_deadline' => 'datetime',
        'capacity' => 'integer',
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }

    public function eventFormat()
    {
        return $this->belongsTo(EventFormat::class, 'event_format_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function scopeOwnedBy($query, $userId)
    {
        return $query->where('organizer_id', $userId);
    }

    public function isFree(): bool
    {
        return $this->payment_method === 'free';
    }

    public function isUpfrontPayment(): bool
    {
        return $this->payment_method === 'upfront';
    }

    public function isOnsitePayment(): bool
    {
        return $this->payment_method === 'onsite';
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return match($this->payment_method) {
            'free' => 'Gratis',
            'upfront' => 'Bayar di Muka',
            'onsite' => 'Bayar di Tempat',
            default => '-',
        };
    }

    /**
     * Get banner URL — supports both external URLs and local file paths.
     */
    public function getBannerUrlAttribute(): ?string
    {
        if ($this->banner === null) {
            return null;
        }

        // External URL (http/https) — return as-is
        if (str_starts_with($this->banner, 'http://') || str_starts_with($this->banner, 'https://')) {
            return $this->banner;
        }

        // Local file path — use asset()
        return asset('storage/' . $this->banner);
    }
}
