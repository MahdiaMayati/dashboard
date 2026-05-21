<?php

namespace App\Policies;

use App\Models\ArtisanProfile;
use App\Models\User;
use App\Policies\Concerns\AllowsStaff;

class ArtisanProfilePolicy
{
    use AllowsStaff;

    public function viewAny(User $user): bool
    {
        return $this->isStaff($user);
    }

    public function view(User $user, ArtisanProfile $artisanProfile): bool
    {
        return $this->isStaff($user);
    }

    public function create(User $user): bool
    {
        return $this->isStaff($user);
    }

    public function update(User $user, ArtisanProfile $artisanProfile): bool
    {
        return $this->isStaff($user);
    }

    public function delete(User $user, ArtisanProfile $artisanProfile): bool
    {
        return $this->isStaff($user);
    }

    public function approve(User $user, ArtisanProfile $artisanProfile): bool
    {
        return $this->isStaff($user);
    }
}
