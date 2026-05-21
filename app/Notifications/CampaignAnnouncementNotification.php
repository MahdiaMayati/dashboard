<?php

namespace App\Notifications;

use App\Models\NotificationCampaign;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class CampaignAnnouncementNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public NotificationCampaign $campaign
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'campaign_id' => $this->campaign->id,
            'title' => $this->campaign->title,
            'body' => $this->campaign->body,
        ];
    }
}
