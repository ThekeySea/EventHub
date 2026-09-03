<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'role',
    'status',
    'is_active',
    'phone',
    'avatar',
    'no_show_count',
    'is_restricted',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'no_show_count' => 'integer',
            'is_restricted' => 'boolean',
        ];
    }

    public function isRestricted(): bool
    {
        return $this->is_restricted;
    }

    public function incrementNoShow(string $paymentMethod = 'free'): void
    {
        // Hanya track no-show untuk event berbayar
        if ($paymentMethod === 'free') {
            return;
        }

        $this->increment('no_show_count');

        // Auto-restrict berdasarkan payment method
        $threshold = $paymentMethod === 'onsite' ? 1 : 5;

        if ($this->no_show_count >= $threshold) {
            $this->update(['is_restricted' => true]);
        }
    }

    public function canRegisterForEvent(string $paymentMethod = 'free'): bool
    {
        if (!$this->is_restricted) {
            return true;
        }

        // Jika restricted, cek apakah masih ada sisa jatah
        // Onsite: max 1 no-show, upfront: max 5 no-show
        $threshold = $paymentMethod === 'onsite' ? 1 : 5;

        return $this->no_show_count < $threshold;
    }

    public function getIsActiveAttribute(): bool
    {
        return ($this->attributes['status'] ?? 'active') === 'active';
    }

    public function setIsActiveAttribute($value): void
    {
        $this->attributes['status'] = filter_var($value, FILTER_VALIDATE_BOOLEAN) || $value === 'active' || $value === 1 || $value === '1' ? 'active' : 'inactive';
    }

    public function organizedEvents()
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class)->latest();
    }

    public function unreadNotifications()
    {
        return $this->notifications()->unread();
    }

    public function unreadNotificationsCount()
    {
        return $this->unreadNotifications()->count();
    }

}