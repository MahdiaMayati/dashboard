<?php

namespace App\Policies;

use App\Models\NotificationCampaign;
use App\Models\User;
use App\Policies\Concerns\AllowsStaff;

class NotificationCampaignPolicy
{
    use AllowsStaff;

    public function viewAny(User $user): bool
    {
        return $this->isStaff($user);
    }

    public function view(User $user, NotificationCampaign $notificationCampaign): bool
    {
        return $this->isStaff($user);
    }

    public function create(User $user): bool
    {
        return $this->isStaff($user);
    }

    public function update(User $user, NotificationCampaign $notificationCampaign): bool
    {
        return $this->isStaff($user);
    }

    public function delete(User $user, NotificationCampaign $notificationCampaign): bool
    {
        return $this->isStaff($user);
    }

    public function send(User $user, NotificationCampaign $notificationCampaign): bool
    {
        return $this->isStaff($user);
    }
}
