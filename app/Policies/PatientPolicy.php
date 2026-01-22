<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\User;
use App\Policies\Concerns\HandlesRoleAuthorization;

class PatientPolicy
{
    use HandlesRoleAuthorization;

    public function viewAny(User $user): bool
    {
        return $this->allows($user, ['Receptionist', 'Doctor', 'Cashier'], ['patient-list']);
    }

    public function view(User $user, Patient $patient): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $this->allows($user, ['Receptionist', 'Doctor'], ['patient-create']);
    }

    public function update(User $user, Patient $patient): bool
    {
        return $this->allows($user, ['Receptionist', 'Doctor'], ['patient-edit']);
    }

    public function delete(User $user, Patient $patient): bool
    {
        return $this->allows($user, [], ['patient-delete']);
    }
}
