<?php

namespace App\Filament\Resources\ArtisanProfiles\Pages;

use App\Enums\ArtisanApprovalStatus;
use App\Filament\Resources\ArtisanProfiles\ArtisanProfileResource;
use App\Models\ArtisanProfile;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\EditRecord;

class EditArtisanProfile extends EditRecord
{
    protected static string $resource = ArtisanProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            Action::make('approve')
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->visible(fn (ArtisanProfile $record): bool => $record->approval_status !== ArtisanApprovalStatus::Approved)
                ->form([
                    Textarea::make('approval_notes')
                        ->label('Notes (optional)')
                        ->rows(2),
                ])
                ->action(function (ArtisanProfile $record, array $data): void {
                    $record->update([
                        'approval_status' => ArtisanApprovalStatus::Approved,
                        'approval_notes' => $data['approval_notes'] ?? null,
                    ]);
                }),
            Action::make('reject')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn (ArtisanProfile $record): bool => $record->approval_status !== ArtisanApprovalStatus::Rejected)
                ->form([
                    Textarea::make('approval_notes')
                        ->label('Rejection reason')
                        ->required()
                        ->rows(3),
                ])
                ->action(function (ArtisanProfile $record, array $data): void {
                    $record->update([
                        'approval_status' => ArtisanApprovalStatus::Rejected,
                        'approval_notes' => $data['approval_notes'],
                    ]);
                }),
            DeleteAction::make(),
        ];
    }
}
