<?php

namespace App\Jobs;

use App\Enums\AccountStatus;
use App\Enums\ArtisanApprovalStatus;
use App\Enums\NotificationAudienceType;
use App\Enums\NotificationCampaignStatus;
use App\Enums\NotificationDeliveryStatus;
use App\Enums\UserRole;
use App\Models\NotificationCampaign;
use App\Models\NotificationRecipient;
use App\Models\User;
use App\Notifications\CampaignAnnouncementNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendNotificationCampaignJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $campaignId
    ) {}

    public function handle(): void
    {
        $campaign = NotificationCampaign::query()->find($this->campaignId);

        if (! $campaign) {
            return;
        }

        if ($campaign->status === NotificationCampaignStatus::Completed) {
            return;
        }

        if (! in_array($campaign->status, [
            NotificationCampaignStatus::Queued,
            NotificationCampaignStatus::Sending,
        ], true)) {
            return;
        }

        $campaign->update(['status' => NotificationCampaignStatus::Sending]);

        $users = match ($campaign->audience_type) {
            NotificationAudienceType::AllCustomers => User::query()
                ->customers()
                ->where('account_status', AccountStatus::Active),
            NotificationAudienceType::AllArtisans => User::query()
                ->where('role', UserRole::Artisan)
                ->whereHas('artisanProfile', fn ($q) => $q->where('approval_status', ArtisanApprovalStatus::Approved)),
            NotificationAudienceType::SingleUser => User::query()->whereKey($campaign->target_user_id),
        };

        if ($campaign->audience_type === NotificationAudienceType::SingleUser && ! $campaign->target_user_id) {
            $campaign->update(['status' => NotificationCampaignStatus::Failed]);

            return;
        }

        try {
            $users->orderBy('id')->chunkById(100, function ($chunk) use ($campaign): void {
                foreach ($chunk as $user) {
                    $recipient = NotificationRecipient::query()->create([
                        'notification_campaign_id' => $campaign->id,
                        'user_id' => $user->id,
                        'delivery_status' => NotificationDeliveryStatus::Pending,
                    ]);

                    try {
                        $user->notify(new CampaignAnnouncementNotification($campaign));
                        $recipient->update([
                            'delivery_status' => NotificationDeliveryStatus::Sent,
                            'delivered_at' => now(),
                        ]);
                    } catch (Throwable $e) {
                        Log::error('Campaign notification failed', [
                            'campaign_id' => $campaign->id,
                            'user_id' => $user->id,
                            'exception' => $e->getMessage(),
                        ]);
                        $recipient->update([
                            'delivery_status' => NotificationDeliveryStatus::Failed,
                        ]);
                    }
                }
            });

            $campaign->update([
                'status' => NotificationCampaignStatus::Completed,
                'sent_at' => now(),
            ]);
        } catch (Throwable $e) {
            Log::error('SendNotificationCampaignJob failed', [
                'campaign_id' => $campaign->id,
                'exception' => $e->getMessage(),
            ]);
            $campaign->update(['status' => NotificationCampaignStatus::Failed]);
        }
    }
}
