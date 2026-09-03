<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $table = 'event_registrations';

    protected $fillable = [
        'event_id',
        'user_id',
        'registration_code',
        'status',
        'registered_at',
        'cancelled_at',
        'payment_confirmed_at',
        'checked_in_at',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'payment_confirmed_at' => 'datetime',
        'checked_in_at' => 'datetime',
    ];

    const STATUS_REGISTERED = 'registered';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_ATTENDED = 'attended';
    const STATUS_PENDING_PAYMENT = 'pending_payment';
    const STATUS_NO_SHOW = 'no_show';
    const STATUS_WAITLISTED = 'waitlisted';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function isRegistered(): bool
    {
        return $this->status === self::STATUS_REGISTERED;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function isPendingPayment(): bool
    {
        return $this->status === self::STATUS_PENDING_PAYMENT;
    }

    public function isNoShow(): bool
    {
        return $this->status === self::STATUS_NO_SHOW;
    }

    public function isWaitlisted(): bool
    {
        return $this->status === self::STATUS_WAITLISTED;
    }

    public function logs()
    {
        return $this->hasMany(RegistrationLog::class);
    }

    public function logAction(string $action, ?string $notes = null): void
    {
        $this->logs()->create([
            'action' => $action,
            'notes' => $notes,
        ]);
    }

    public function confirmPayment(): void
    {
        $this->update([
            'status' => self::STATUS_REGISTERED,
            'payment_confirmed_at' => now(),
        ]);
    }

    public function checkIn(): void
    {
        $this->update([
            'status' => self::STATUS_ATTENDED,
            'checked_in_at' => now(),
        ]);
    }

    public function markNoShow(): void
    {
        $this->update(['status' => self::STATUS_NO_SHOW]);
        $paymentMethod = $this->event->payment_method ?? 'free';
        $this->user->incrementNoShow($paymentMethod);
    }
}
