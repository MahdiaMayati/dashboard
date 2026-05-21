<?php

namespace App\Filament\Resources\ArtisanProfiles\RelationManagers;

use App\Filament\Resources\Reviews\ReviewResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReviewsRelationManager extends RelationManager
{
    protected static string $relationship = 'reviews';

    protected static ?string $relatedResource = ReviewResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('rating'),
                TextColumn::make('moderation_status')->badge(),
                TextColumn::make('customer.name'),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
