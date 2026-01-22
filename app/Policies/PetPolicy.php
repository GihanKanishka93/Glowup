<?php

namespace App\Policies;

use App\Models\Pet;
use App\Models\User;
use App\Policies\Concerns\HandlesRoleAuthorization;

class PetPolicy
{
    use HandlesRoleAuthorization;

    public function viewAny(User $user): bool
    {
        return $this->allows($user, ['Receptionist', 'Doctor'], ['pet-list']);
    }

    public function view(User $user, Pet $pet): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $this->allows($user, ['Receptionist', 'Doctor'], ['pet-create']);
    }

    public function update(User $user, Pet $pet): bool
    {
        return $this->allows($user, ['Receptionist', 'Doctor'], ['pet-edit']);
    }

    public function delete(User $user, Pet $pet): bool
    {
        return $this->allows($user, [], ['pet-delete']);
    }
}
