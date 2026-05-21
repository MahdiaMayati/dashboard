<?php

namespace App\Policies;

use App\Models\PlatformSetting;
use App\Models\User;
use App\Policies\Concerns\AllowsStaff;

class PlatformSettingPolicy
{
    use AllowsStaff;

    public function viewAny(User $user): bool
    {
        return $this->isStaff($user);
    }

    public function view(User $user, PlatformSetting $platformSetting): bool
    {
        return $this->isStaff($user);
    }

    public function update(User $user, PlatformSetting $platformSetting): bool
    {
        return $this->isStaff($user);
    }
}
