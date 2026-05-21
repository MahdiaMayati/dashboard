<?php

namespace App\Filament\Resources\Users\Pages;

use App\Enums\AccountStatus;
use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            Action::make('activate')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn (User $record): bool => $record->account_status !== AccountStatus::Active)
                ->requiresConfirmation()
                ->action(function (User $record): void {
                    $record->update([
                        'account_status' => AccountStatus::Active,
                        'suspended_at' => null,
                        'blocked_at' => null,
                    ]);
                }),
            Action::make('suspend')
                ->icon('heroicon-o-pause-circle')
                ->color('warning')
                ->visible(fn (User $record): bool => $record->account_status !== AccountStatus::Suspended)
                ->requiresConfirmation()
                ->action(function (User $record): void {
                    $record->update([
                        'account_status' => AccountStatus::Suspended,
                        'suspended_at' => now(),
                    ]);
                }),
            Action::make('block')
                ->icon('heroicon-o-no-symbol')
                ->color('danger')
                ->visible(fn (User $record): bool => $record->account_status !== AccountStatus::Blocked)
                ->requiresConfirmation()
                ->action(function (User $record): void {
                    $record->update([
                        'account_status' => AccountStatus::Blocked,
                        'blocked_at' => now(),
                    ]);
                }),
            DeleteAction::make(),
        ];
    }
}
