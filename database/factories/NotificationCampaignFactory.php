<?php

namespace Database\Factories;

use App\Enums\NotificationAudienceType;
use App\Enums\NotificationCampaignStatus;
use App\Models\NotificationCampaign;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NotificationCampaign>
 */
class NotificationCampaignFactory extends Factory
{
    protected $model = NotificationCampaign::class;

    public function definition(): array
    {
        return [
            'created_by_user_id' => User::factory()->state(['role' => \App\Enums\UserRole::Admin]),
            'title' => fake()->sentence(4),
            'body' => fake()->paragraphs(3, true),
            'audience_type' => NotificationAudienceType::AllCustomers,
            'target_user_id' => null,
            'status' => NotificationCampaignStatus::Draft,
            'sent_at' => null,
        ];
    }
}
