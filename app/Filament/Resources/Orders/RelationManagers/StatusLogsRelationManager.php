<?php

namespace App\Filament\Resources\Orders\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StatusLogsRelationManager extends RelationManager
{
    protected static string $relationship = 'statusLogs';

    protected static ?string $title = 'Status history';

    public function isReadOnly(): bool
    {
        return true;
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('from_status')
                    ->badge()
                    ->placeholder('—'),
                TextColumn::make('to_status')
                    ->badge(),
                TextColumn::make('changedBy.name')
                    ->label('Changed by')
                    ->placeholder('System'),
                TextColumn::make('note')
                    ->wrap()
                    ->placeholder('—'),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50]);
    }
}
