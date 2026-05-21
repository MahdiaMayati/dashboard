<?php

namespace App\Filament\Resources\NotificationCampaigns\Pages;

use App\Enums\NotificationCampaignStatus;
use App\Filament\Resources\NotificationCampaigns\NotificationCampaignResource;
use Filament\Resources\Pages\CreateRecord;

class CreateNotificationCampaign extends CreateRecord
{
    protected static string $resource = NotificationCampaignResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by_user_id'] = auth()->id();
        $data['status'] = NotificationCampaignStatus::Draft;

        return $data;
    }
}
