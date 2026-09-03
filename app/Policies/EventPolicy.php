<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'organizer';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Event $event): bool
    {
        return $user->role === 'organizer' && $event->organizer_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'organizer';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Event $event): bool
    {
        if ($user->role !== 'organizer' || $event->organizer_id !== $user->id) {
            return false;
        }

        // Draft, rejected, DAN published bisa diedit (SRS FR-08.6)
        // Published yang diedit akan kembali ke pending untuk review ulang
        return in_array($event->status, ['draft', 'rejected', 'published']);
    }

    /**
     * Determine whether the user can submit the model for review.
     */
    public function submit(User $user, Event $event): bool
    {
        if ($user->role !== 'organizer' || $event->organizer_id !== $user->id) {
            return false;
        }

        // Only draft or rejected can be submitted
        return in_array($event->status, ['draft', 'rejected']);
    }
}
