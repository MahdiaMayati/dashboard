<?php

namespace App\Filament\Resources\NotificationCampaigns\Tables;

use App\Enums\NotificationCampaignStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class NotificationCampaignsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('title')
                    ->limit(40)
                    ->searchable(),
                TextColumn::make('audience_type')->badge(),
                TextColumn::make('status')->badge(),
                TextColumn::make('createdBy.name')
                    ->label('Created by'),
                TextColumn::make('sent_at')
                    ->dateTime()
                    ->placeholder('—')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(collect(NotificationCampaignStatus::cases())->mapWithKeys(
                        fn (NotificationCampaignStatus $s): array => [$s->value => (string) str($s->name)->headline()]
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
