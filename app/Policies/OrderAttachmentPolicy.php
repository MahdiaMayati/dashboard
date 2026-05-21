<?php

namespace App\Policies;

use App\Models\OrderAttachment;
use App\Models\User;
use App\Policies\Concerns\AllowsStaff;

class OrderAttachmentPolicy
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

    public function delete(User $user, OrderAttachment $orderAttachment): bool
    {
        return $this->isStaff($user);
    }
}
