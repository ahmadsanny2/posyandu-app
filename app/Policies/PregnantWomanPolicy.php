<?php

namespace App\Policies;

use App\Models\PregnantWoman;
use App\Models\User;

class PregnantWomanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isKader() || $user->isPuskesmas();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PregnantWoman $pregnantWoman): bool
    {
        if ($user->isAdmin() || $user->isKader() || $user->isPuskesmas()) {
            return true;
        }

        return $user->isParent() && $pregnantWoman->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isKader() || $user->isParent();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PregnantWoman $pregnantWoman): bool
    {
        if ($user->isAdmin() || $user->isKader()) {
            return true;
        }

        return $user->isParent() && $pregnantWoman->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PregnantWoman $pregnantWoman): bool
    {
        if ($user->isAdmin() || $user->isKader()) {
            return true;
        }

        return $user->isParent() && $pregnantWoman->user_id === $user->id;
    }
}
