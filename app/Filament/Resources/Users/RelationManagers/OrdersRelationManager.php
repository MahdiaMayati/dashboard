<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'ordersAsCustomer';

    protected static ?string $relatedResource = OrderResource::class;

    protected static ?string $title = 'Orders';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('serviceCategory.name')
                    ->label('Category'),
                TextColumn::make('scheduled_at')
                    ->dateTime()
                    ->placeholder('—'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
