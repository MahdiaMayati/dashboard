<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use App\Policies\Concerns\AllowsStaff;

class ReviewPolicy
{
    use AllowsStaff;

    public function viewAny(User $user): bool
    {
        return $this->isStaff($user);
    }

    public function view(User $user, Review $review): bool
    {
        return $this->isStaff($user);
    }

    public function create(User $user): bool
    {
        return $this->isStaff($user);
    }

    public function update(User $user, Review $review): bool
    {
        return $this->isStaff($user);
    }

    public function delete(User $user, Review $review): bool
    {
        return $this->isStaff($user);
    }
}
