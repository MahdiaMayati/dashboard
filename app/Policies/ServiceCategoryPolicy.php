<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\ServiceCategory;
use App\Models\User;
use App\Policies\Concerns\AllowsStaff;

class ServiceCategoryPolicy
{
    use AllowsStaff;

    public function viewAny(User $user): bool
    {
        return $this->isStaff($user);
    }

    public function view(User $user, ServiceCategory $serviceCategory): bool
    {
        return $this->isStaff($user);
    }

    public function create(User $user): bool
    {
        return $this->isStaff($user);
    }

    public function update(User $user, ServiceCategory $serviceCategory): bool
    {
        return $this->isStaff($user);
    }

    public function delete(User $user, ServiceCategory $serviceCategory): bool
    {
        return $user->role === UserRole::Admin;
    }
}
