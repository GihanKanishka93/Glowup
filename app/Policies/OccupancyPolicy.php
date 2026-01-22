<?php

namespace App\Policies;

use App\Models\Occupancy;
use App\Models\User;
use App\Policies\Concerns\HandlesRoleAuthorization;

class OccupancyPolicy
{
    use HandlesRoleAuthorization;

    public function viewAny(User $user): bool
    {
        return $this->allows($user, ['Doctor', 'Nurse'], ['occupancy-list']);
    }

    public function view(User $user, Occupancy $occupancy): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $this->allows($user, ['Doctor'], ['occupancy-create']);
    }

    public function update(User $user, Occupancy $occupancy): bool
    {
        return $this->allows($user, ['Doctor', 'Nurse'], ['occupancy-edit']);
    }

    public function delete(User $user, Occupancy $occupancy): bool
    {
        return $this->allows($user, ['Doctor'], ['occupancy-delete']);
    }
}
