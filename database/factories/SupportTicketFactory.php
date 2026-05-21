<?php

namespace Database\Factories;

use App\Enums\SupportTicketPriority;
use App\Enums\SupportTicketStatus;
use App\Enums\UserRole;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SupportTicket>
 */
class SupportTicketFactory extends Factory
{
    protected $model = SupportTicket::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['role' => UserRole::Customer]),
            'related_order_id' => null,
            'assigned_to_user_id' => null,
            'subject' => fake()->sentence(6),
            'status' => SupportTicketStatus::Open,
            'priority' => fake()->optional()->randomElement([
                SupportTicketPriority::Low,
                SupportTicketPriority::Normal,
                SupportTicketPriority::High,
            ]),
            'opened_by_role' => UserRole::Customer->value,
            'resolved_at' => null,
            'closed_at' => null,
        ];
    }

    public function resolved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => SupportTicketStatus::Resolved,
            'resolved_at' => now(),
        ]);
    }
}
