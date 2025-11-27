<?php

namespace App\Policies;

use App\Models\RoomType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoomTypePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user !== null;
    }

    public function view(User $user, RoomType $roomType): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['user', 'admin', 'super_admin'], true) || $user->hasAnyRole(['user', 'admin', 'super_admin']);
    }

    public function update(User $user, RoomType $roomType): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, RoomType $roomType): bool
    {
        return $user->isSuperAdmin();
    }
}

