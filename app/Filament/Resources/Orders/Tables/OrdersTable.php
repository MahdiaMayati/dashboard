<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Enums\OrderStatus;
use App\Models\ArtisanProfile;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('status')->badge()->sortable(),
                TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable(),
                TextColumn::make('artisanProfile.user.name')
                    ->label('Artisan')
                    ->placeholder('—'),
                TextColumn::make('serviceCategory.name')
                    ->label('Category'),
                TextColumn::make('scheduled_at')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('—'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(collect(OrderStatus::cases())->mapWithKeys(
                        fn (OrderStatus $s): array => [$s->value => (string) str($s->name)->headline()]
                    )),
                SelectFilter::make('service_category_id')
                    ->relationship('serviceCategory', 'name')
                    ->label('Category'),
                SelectFilter::make('customer_id')
                    ->relationship('customer', 'email')
                    ->label('Customer')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('artisan_profile_id')
                    ->label('Artisan')
                    ->options(fn (): array => ArtisanProfile::query()
                        ->with('user')
                        ->orderBy('id')
                        ->get()
                        ->mapWithKeys(fn (ArtisanProfile $p): array => [
                            $p->id => ($p->user?->name ?? 'Profile').' #'.$p->id,
                        ])
                        ->all()),
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
