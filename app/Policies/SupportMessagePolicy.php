<?php

namespace App\Policies;

use App\Models\SupportMessage;
use App\Models\User;
use App\Policies\Concerns\AllowsStaff;

class SupportMessagePolicy
{
    use AllowsStaff;

    public function viewAny(User $user): bool
    {
        return $this->isStaff($user);
    }

    public function create(User $user): bool
    {
        return $this->isStaff($user);
    }

    public function update(User $user, SupportMessage $supportMessage): bool
    {
        return false;
    }

    public function delete(User $user, SupportMessage $supportMessage): bool
    {
        return $this->isStaff($user);
    }
}
