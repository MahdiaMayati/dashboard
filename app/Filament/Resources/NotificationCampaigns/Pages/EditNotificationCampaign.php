<?php

namespace App\Filament\Resources\NotificationCampaigns\Pages;

use App\Enums\NotificationCampaignStatus;
use App\Filament\Resources\NotificationCampaigns\NotificationCampaignResource;
use App\Jobs\SendNotificationCampaignJob;
use App\Models\NotificationCampaign;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditNotificationCampaign extends EditRecord
{
    protected static string $resource = NotificationCampaignResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            Action::make('queueSend')
                ->label('Queue send')
                ->icon('heroicon-o-paper-airplane')
                ->color('primary')
                ->visible(fn (NotificationCampaign $record): bool => in_array($record->status, [
                    NotificationCampaignStatus::Draft,
                    NotificationCampaignStatus::Failed,
                ], true))
                ->requiresConfirmation()
                ->action(function (NotificationCampaign $record): void {
                    $record->update(['status' => NotificationCampaignStatus::Queued]);
                    SendNotificationCampaignJob::dispatch($record->id);
                }),
            DeleteAction::make(),
        ];
    }
}
