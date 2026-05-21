<?php

namespace App\Filament\Resources\NotificationCampaigns\Pages;

use App\Filament\Resources\NotificationCampaigns\NotificationCampaignResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewNotificationCampaign extends ViewRecord
{
    protected static string $resource = NotificationCampaignResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
