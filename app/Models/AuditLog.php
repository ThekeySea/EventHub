<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'subject_type',
        'subject_id',
        'old_values',
        'new_values',
        'ip_address',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Log an activity.
     */
    public static function log(
        string $action,
        Model $subject,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?Request $request = null
    ): self {
        return self::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'subject_type' => get_class($subject),
            'subject_id' => $subject->id,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => $request?->ip(),
        ]);
    }

    /**
     * Get the human-readable action label.
     */
    public function getActionLabelAttribute(): string
    {
        return match($this->action) {
            'event_approved' => 'Menyetujui event',
            'event_rejected' => 'Menolak event',
            'event_deleted' => 'Menghapus event',
            'event_created' => 'Membuat event',
            'event_submitted' => 'Mengajukan event',
            'event_cancelled' => 'Membatalkan event',
            'user_role_changed' => 'Mengubah role pengguna',
            'user_deactivated' => 'Menonaktifkan pengguna',
            'user_activated' => 'Mengaktifkan pengguna',
            'category_created' => 'Membuat kategori',
            'category_updated' => 'Memperbarui kategori',
            'report_resolved' => 'Menyelesaikan laporan',
            'report_dismissed' => 'Menolak laporan',
            default => ucfirst(str_replace('_', ' ', $this->action)),
        };
    }
}
