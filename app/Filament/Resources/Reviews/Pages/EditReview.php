<?php

namespace App\Filament\Resources\Reviews\Pages;

use App\Enums\ReviewModerationStatus;
use App\Filament\Resources\Reviews\ReviewResource;
use App\Models\Review;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditReview extends EditRecord
{
    protected static string $resource = ReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            Action::make('hide')
                ->label('Hide review')
                ->icon('heroicon-o-eye-slash')
                ->color('warning')
                ->visible(fn (Review $record): bool => $record->moderation_status !== ReviewModerationStatus::Hidden)
                ->requiresConfirmation()
                ->action(function (Review $record): void {
                    $record->update([
                        'moderation_status' => ReviewModerationStatus::Hidden,
                        'moderated_by_user_id' => auth()->id(),
                        'moderated_at' => now(),
                    ]);
                }),
            Action::make('show')
                ->label('Show review')
                ->icon('heroicon-o-eye')
                ->color('success')
                ->visible(fn (Review $record): bool => $record->moderation_status !== ReviewModerationStatus::Visible)
                ->requiresConfirmation()
                ->action(function (Review $record): void {
                    $record->update([
                        'moderation_status' => ReviewModerationStatus::Visible,
                        'moderated_by_user_id' => auth()->id(),
                        'moderated_at' => now(),
                    ]);
                }),
            DeleteAction::make(),
        ];
    }
}
