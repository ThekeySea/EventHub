<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistrationLog extends Model
{
    protected $fillable = [
        'registration_id',
        'action',
        'notes',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    public function getActionLabelAttribute(): string
    {
        return match($this->action) {
            'created' => 'Pendaftaran dibuat',
            'payment_confirmed' => 'Pembayaran dikonfirmasi',
            'checked_in' => 'Check-in hadir',
            'no_show' => 'Tidak hadir (no-show)',
            'cancelled' => 'Dibatalkan',
            'waitlisted' => 'Masuk daftar tunggu',
            'promoted' => 'Dipromosikan dari daftar tunggu',
            default => ucfirst(str_replace('_', ' ', $this->action)),
        };
    }
}
