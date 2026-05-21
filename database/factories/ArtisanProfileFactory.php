<?php

namespace Database\Factories;

use App\Enums\ArtisanApprovalStatus;
use App\Models\ArtisanProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ArtisanProfile>
 */
class ArtisanProfileFactory extends Factory
{
    protected $model = ArtisanProfile::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['role' => \App\Enums\UserRole::Artisan]),
            'specialty_title' => fake()->jobTitle(),
            'bio' => fake()->paragraphs(2, true),
            'latitude' => fake()->optional()->latitude(),
            'longitude' => fake()->optional()->longitude(),
            'address' => fake()->address(),
            'profile_image_path' => null,
            'id_proof_path' => null,
            'profession_proof_path' => null,
            'approval_status' => ArtisanApprovalStatus::Approved,
            'approval_notes' => null,
            'is_available' => true,
            'is_accepting_orders' => true,
            'average_rating' => fake()->randomFloat(2, 3, 5),
            'completed_orders_count' => fake()->numberBetween(0, 120),
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'approval_status' => ArtisanApprovalStatus::Pending,
            'average_rating' => null,
            'completed_orders_count' => 0,
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'approval_status' => ArtisanApprovalStatus::Rejected,
            'approval_notes' => fake()->sentence(),
        ]);
    }
}
