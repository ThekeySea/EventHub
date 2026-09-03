<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'action_url',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    // Types
    const TYPE_EVENT_APPROVED = 'event_approved';
    const TYPE_EVENT_REJECTED = 'event_rejected';
    const TYPE_REGISTRATION_SUCCESS = 'registration_success';
    const TYPE_REGISTRATION_CANCELLED = 'registration_cancelled';
    const TYPE_EVENT_REMINDER = 'event_reminder';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Helper: Create notification
    public static function createFor(int $userId, string $type, string $title, string $message, ?string $actionUrl = null): self
    {
        return self::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'action_url' => $actionUrl,
        ]);
    }

    // Mark as read
    public function markAsRead(): void
    {
        $this->update(['is_read' => true]);
    }
}
