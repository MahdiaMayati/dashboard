<?php

namespace Database\Factories;

use App\Enums\ReviewModerationStatus;
use App\Models\ArtisanProfile;
use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function configure(): static
    {
        return $this->afterCreating(function (Review $review): void {
            $order = $review->order;
            $review->forceFill([
                'customer_id' => $order->customer_id,
                'artisan_profile_id' => $order->artisan_profile_id,
            ])->saveQuietly();
        });
    }

    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'customer_id' => User::factory()->state(['role' => \App\Enums\UserRole::Customer]),
            'artisan_profile_id' => ArtisanProfile::factory(),
            'rating' => fake()->numberBetween(1, 5),
            'comment' => fake()->optional(0.7)->paragraph(),
            'moderation_status' => ReviewModerationStatus::Visible,
            'moderated_by_user_id' => null,
            'moderated_at' => null,
        ];
    }

    public function hidden(): static
    {
        return $this->state(fn (array $attributes) => [
            'moderation_status' => ReviewModerationStatus::Hidden,
            'moderated_at' => now(),
        ]);
    }
}
