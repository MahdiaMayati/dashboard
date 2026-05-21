<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use App\Policies\Concerns\AllowsStaff;

class OrderPolicy
{
    use AllowsStaff;

    public function viewAny(User $user): bool
    {
        return $this->isStaff($user);
    }

    public function view(User $user, Order $order): bool
    {
        return $this->isStaff($user);
    }

    public function create(User $user): bool
    {
        return $this->isStaff($user);
    }

    public function update(User $user, Order $order): bool
    {
        return $this->isStaff($user);
    }

    public function delete(User $user, Order $order): bool
    {
        return $this->isStaff($user);
    }
}
