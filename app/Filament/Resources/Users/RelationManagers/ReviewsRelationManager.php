<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Filament\Resources\Reviews\ReviewResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReviewsRelationManager extends RelationManager
{
    protected static string $relationship = 'reviews';

    protected static ?string $relatedResource = ReviewResource::class;

    protected static ?string $title = 'Reviews';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('order_id')
                    ->label('Order'),
                TextColumn::make('rating')
                    ->sortable(),
                TextColumn::make('moderation_status')
                    ->badge(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
