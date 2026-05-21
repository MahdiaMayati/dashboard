<?php

namespace App\Policies;

use App\Models\SupportTicket;
use App\Models\User;
use App\Policies\Concerns\AllowsStaff;

class SupportTicketPolicy
{
    use AllowsStaff;

    public function viewAny(User $user): bool
    {
        return $this->isStaff($user);
    }

    public function view(User $user, SupportTicket $supportTicket): bool
    {
        return $this->isStaff($user);
    }

    public function create(User $user): bool
    {
        return $this->isStaff($user);
    }

    public function update(User $user, SupportTicket $supportTicket): bool
    {
        return $this->isStaff($user);
    }

    public function delete(User $user, SupportTicket $supportTicket): bool
    {
        return $this->isStaff($user);
    }

    public function reply(User $user, SupportTicket $supportTicket): bool
    {
        return $this->isStaff($user);
    }
}
