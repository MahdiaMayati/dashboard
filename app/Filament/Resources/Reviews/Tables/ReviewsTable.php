<?php

namespace App\Filament\Resources\Reviews\Tables;

use App\Enums\ReviewModerationStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('customer.name')
                    ->label('Reviewer')
                    ->searchable(),
                TextColumn::make('artisanProfile.user.name')
                    ->label('Artisan'),
                TextColumn::make('order_id'),
                TextColumn::make('rating')->sortable(),
                TextColumn::make('moderation_status')->badge(),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('moderation_status')
                    ->options(collect(ReviewModerationStatus::cases())->mapWithKeys(
                        fn (ReviewModerationStatus $s): array => [$s->value => (string) str($s->name)->headline()]
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
