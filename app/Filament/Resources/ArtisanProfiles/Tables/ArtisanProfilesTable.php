<?php

namespace App\Filament\Resources\ArtisanProfiles\Tables;

use App\Enums\ArtisanApprovalStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ArtisanProfilesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Name')
                    ->searchable(),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('specialty_title')
                    ->limit(30),
                TextColumn::make('approval_status')
                    ->badge(),
                TextColumn::make('average_rating')
                    ->sortable(),
                IconColumn::make('is_available')
                    ->boolean(),
                IconColumn::make('is_accepting_orders')
                    ->boolean(),
                TextColumn::make('completed_orders_count')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('approval_status')
                    ->options(collect(ArtisanApprovalStatus::cases())->mapWithKeys(
                        fn (ArtisanApprovalStatus $s): array => [$s->value => (string) str($s->name)->headline()]
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
