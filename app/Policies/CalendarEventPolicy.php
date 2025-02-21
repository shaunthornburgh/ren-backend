<?php

namespace App\Policies;

use App\Models\CalendarEvent;
use App\Models\User;

class CalendarEventPolicy
{
    /**
     * Determine if the given user can update the specified event.
     */
    public function update(User $user, CalendarEvent $event): bool
    {
        return $user->id === $event->created_by;
    }

    /**
     * Determine if the given user can delete the specified event.
     */
    public function delete(User $user, CalendarEvent $event): bool
    {
        return $user->id === $event->created_by;
    }
}
