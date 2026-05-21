<?php

namespace App\Policies;

use App\Models\OrderStatusLog;
use App\Models\User;
use App\Policies\Concerns\AllowsStaff;

class OrderStatusLogPolicy
{
    use AllowsStaff;

    public function viewAny(User $user): bool
    {
        return $this->isStaff($user);
    }

    public function view(User $user, OrderStatusLog $orderStatusLog): bool
    {
        return $this->isStaff($user);
    }
}
