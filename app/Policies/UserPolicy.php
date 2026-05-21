<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;
use App\Policies\Concerns\AllowsStaff;

class UserPolicy
{
    use AllowsStaff;

    public function viewAny(User $user): bool
    {
        return $this->isStaff($user);
    }

    public function view(User $user, User $model): bool
    {
        return $this->isStaff($user) && $model->role === UserRole::Customer;
    }

    public function create(User $user): bool
    {
        return $this->isStaff($user);
    }

    public function update(User $user, User $model): bool
    {
        return $this->isStaff($user) && $model->role === UserRole::Customer;
    }

    public function delete(User $user, User $model): bool
    {
        return $user->role === UserRole::Admin && $model->role === UserRole::Customer;
    }
}
