<?php

namespace App\Policies\Concerns;

use App\Enums\UserRole;
use App\Models\User;

trait AllowsStaff
{
    protected function isStaff(User $user): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::Support], true);
    }
}
