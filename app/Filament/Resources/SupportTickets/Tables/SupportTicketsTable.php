<?php

namespace App\Filament\Resources\SupportTickets\Tables;

use App\Enums\SupportTicketStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SupportTicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('subject')
                    ->limit(40)
                    ->searchable(),
                TextColumn::make('user.email')
                    ->label('User')
                    ->searchable(),
                TextColumn::make('status')->badge(),
                TextColumn::make('priority')->badge()->placeholder('—'),
                TextColumn::make('assignedTo.name')
                    ->label('Assignee')
                    ->placeholder('—'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(collect(SupportTicketStatus::cases())->mapWithKeys(
                        fn (SupportTicketStatus $s): array => [$s->value => (string) str($s->name)->headline()]
                    )),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
