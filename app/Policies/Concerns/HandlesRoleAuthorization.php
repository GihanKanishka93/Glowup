<?php

namespace App\Policies\Concerns;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

trait HandlesRoleAuthorization
{
    use HandlesAuthorization;

    /**
     * Globally allow super administrators to bypass policy checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('SAdmin')) {
            return true;
        }

        return null;
    }

    /**
     * Determine if the given user is allowed to perform an action based on role or permission membership.
     */
    protected function allows(User $user, array $roles = [], array $permissions = []): bool
    {
        if ($user->hasRole('Admin')) {
            return true;
        }

        if (! empty($roles) && $user->hasAnyRole($roles)) {
            return true;
        }

        if (! empty($permissions) && $user->hasAnyPermission($permissions)) {
            return true;
        }

        return false;
    }
}
