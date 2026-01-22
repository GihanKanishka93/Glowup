<?php

namespace App\Policies;

use App\Models\Bill;
use App\Models\User;
use App\Policies\Concerns\HandlesRoleAuthorization;

class BillPolicy
{
    use HandlesRoleAuthorization;

    public function viewAny(User $user): bool
    {
        return $this->allows($user, ['Cashier'], ['bill-list', 'bill-view']);
    }

    public function view(User $user, Bill $bill): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $this->allows($user, ['Cashier'], ['bill-create']);
    }

    public function update(User $user, Bill $bill): bool
    {
        return $this->allows($user, ['Cashier'], ['bill-edit']);
    }

    public function delete(User $user, Bill $bill): bool
    {
        return $this->allows($user, [], ['bill-delete']);
    }
}
