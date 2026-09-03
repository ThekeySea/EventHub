<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventReport extends Model
{
    protected $fillable = [
        'event_id',
        'user_id',
        'reason',
        'description',
        'status',
        'admin_notes',
        'reviewed_by',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function resolve(string $notes, int $adminId): void
    {
        $this->update([
            'status' => 'resolved',
            'admin_notes' => $notes,
            'reviewed_by' => $adminId,
        ]);
    }

    public function dismiss(string $notes, int $adminId): void
    {
        $this->update([
            'status' => 'dismissed',
            'admin_notes' => $notes,
            'reviewed_by' => $adminId,
        ]);
    }

    public function getReasonLabelAttribute(): string
    {
        return match($this->reason) {
            'spam' => 'Spam',
            'inappropriate' => 'Tidak Pantas',
            'scam' => 'Penipuan',
            'misleading' => 'Menyesatkan',
            'other' => 'Lainnya',
            default => ucfirst($this->reason),
        };
    }
}
