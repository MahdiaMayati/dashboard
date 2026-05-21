<?php

namespace App\Filament\Resources\SupportTickets\Pages;

use App\Enums\SupportTicketStatus;
use App\Filament\Resources\SupportTickets\SupportTicketResource;
use App\Models\SupportTicket;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSupportTicket extends EditRecord
{
    protected static string $resource = SupportTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            Action::make('resolve')
                ->icon('heroicon-o-check')
                ->color('success')
                ->visible(fn (SupportTicket $record): bool => $record->status !== SupportTicketStatus::Resolved)
                ->requiresConfirmation()
                ->action(function (SupportTicket $record): void {
                    $record->update([
                        'status' => SupportTicketStatus::Resolved,
                        'resolved_at' => now(),
                    ]);
                }),
            Action::make('close')
                ->icon('heroicon-o-lock-closed')
                ->color('gray')
                ->visible(fn (SupportTicket $record): bool => $record->status !== SupportTicketStatus::Closed)
                ->requiresConfirmation()
                ->action(function (SupportTicket $record): void {
                    $record->update([
                        'status' => SupportTicketStatus::Closed,
                        'closed_at' => now(),
                    ]);
                }),
            DeleteAction::make(),
        ];
    }
}
