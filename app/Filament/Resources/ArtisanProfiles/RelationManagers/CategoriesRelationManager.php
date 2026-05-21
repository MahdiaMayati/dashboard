<?php

namespace App\Filament\Resources\ArtisanProfiles\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'serviceCategories';

    protected static ?string $title = 'Service categories';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('slug'),
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect(),
            ])
            ->recordActions([
                DetachAction::make(),
            ]);
    }
}
