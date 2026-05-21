<?php

namespace Database\Factories;

use App\Models\SupportMessage;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SupportMessage>
 */
class SupportMessageFactory extends Factory
{
    protected $model = SupportMessage::class;

    public function definition(): array
    {
        return [
            'support_ticket_id' => SupportTicket::factory(),
            'sender_user_id' => User::factory(),
            'message' => fake()->paragraphs(2, true),
            'is_internal' => false,
        ];
    }
}
