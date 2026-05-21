<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Enums\OrderStatus;
use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            Action::make('markCompleted')
                ->label('Mark completed')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn (Order $record): bool => $record->status !== OrderStatus::Completed)
                ->requiresConfirmation()
                ->action(function (Order $record): void {
                    $record->update([
                        'status' => OrderStatus::Completed,
                        'completed_at' => now(),
                    ]);
                }),
            Action::make('markDisputed')
                ->label('Mark disputed')
                ->icon('heroicon-o-exclamation-triangle')
                ->color('warning')
                ->visible(fn (Order $record): bool => $record->status !== OrderStatus::Disputed)
                ->form([
                    Textarea::make('disputed_reason')
                        ->label('Reason')
                        ->required()
                        ->rows(3),
                ])
                ->action(function (Order $record, array $data): void {
                    $record->update([
                        'status' => OrderStatus::Disputed,
                        'disputed_reason' => $data['disputed_reason'],
                    ]);
                }),
            Action::make('cancelOrder')
                ->label('Cancel order')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn (Order $record): bool => ! in_array($record->status, [OrderStatus::Cancelled, OrderStatus::Completed], true))
                ->form([
                    Textarea::make('cancelled_reason')
                        ->label('Cancellation reason')
                        ->required()
                        ->rows(3),
                ])
                ->action(function (Order $record, array $data): void {
                    $record->update([
                        'status' => OrderStatus::Cancelled,
                        'cancelled_at' => now(),
                        'cancelled_reason' => $data['cancelled_reason'],
                    ]);
                }),
            DeleteAction::make(),
        ];
    }
}
