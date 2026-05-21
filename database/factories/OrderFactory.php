<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\ArtisanProfile;
use App\Models\Order;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'customer_id' => User::factory()->state(['role' => \App\Enums\UserRole::Customer]),
            'artisan_profile_id' => ArtisanProfile::factory(),
            'service_category_id' => ServiceCategory::factory(),
            'status' => OrderStatus::Pending,
            'title' => fake()->optional()->sentence(3),
            'description' => fake()->paragraph(),
            'scheduled_at' => fake()->optional()->dateTimeBetween('now', '+30 days'),
            'address' => fake()->address(),
            'latitude' => fake()->optional()->latitude(),
            'longitude' => fake()->optional()->longitude(),
            'completion_notes' => null,
            'cancelled_reason' => null,
            'disputed_reason' => null,
            'completed_at' => null,
            'cancelled_at' => null,
        ];
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::Completed,
            'completed_at' => now(),
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::Cancelled,
            'cancelled_at' => now(),
            'cancelled_reason' => fake()->sentence(),
        ]);
    }

    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::InProgress,
        ]);
    }
}
