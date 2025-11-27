<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user !== null;
    }

    public function view(User $user, Booking $booking): bool
    {
        return $user->isAdmin() || $booking->created_by === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'user' || $user->hasRole('user');
    }

    public function update(User $user, Booking $booking): bool
    {
        return $user->isAdmin() || $booking->created_by === $user->id;
    }

    public function delete(User $user, Booking $booking): bool
    {
        return $user->isSuperAdmin();
    }
}


