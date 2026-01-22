<?php

namespace App\Policies;

use App\Models\Admission;
use App\Models\User;
use App\Policies\Concerns\HandlesRoleAuthorization;

class AdmissionPolicy
{
    use HandlesRoleAuthorization;

    public function viewAny(User $user): bool
    {
        return $this->allows($user, ['Doctor', 'Nurse', 'Receptionist'], ['admission-list', 'admission-medical-view']);
    }

    public function view(User $user, Admission $admission): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $this->allows($user, ['Doctor', 'Receptionist'], ['admission-create']);
    }

    public function update(User $user, Admission $admission): bool
    {
        return $this->allows($user, ['Doctor', 'Nurse'], ['admission-edit']);
    }

    public function delete(User $user, Admission $admission): bool
    {
        return $this->allows($user, [], ['admission-delete']);
    }
}
