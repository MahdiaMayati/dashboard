<?php

namespace Database\Factories;

use App\Models\AdminNote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AdminNote>
 */
class AdminNoteFactory extends Factory
{
    protected $model = AdminNote::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['role' => \App\Enums\UserRole::Customer]),
            'admin_user_id' => User::factory()->state(['role' => \App\Enums\UserRole::Admin]),
            'note' => fake()->paragraph(),
        ];
    }
}
