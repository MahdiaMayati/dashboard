<?php

namespace App\Policies;

use App\Models\AdminNote;
use App\Models\User;
use App\Policies\Concerns\AllowsStaff;

class AdminNotePolicy
{
    use AllowsStaff;

    public function viewAny(User $user): bool
    {
        return $this->isStaff($user);
    }

    public function view(User $user, AdminNote $adminNote): bool
    {
        return $this->isStaff($user);
    }

    public function create(User $user): bool
    {
        return $this->isStaff($user);
    }

    public function update(User $user, AdminNote $adminNote): bool
    {
        return $this->isStaff($user);
    }

    public function delete(User $user, AdminNote $adminNote): bool
    {
        return $this->isStaff($user);
    }
}
