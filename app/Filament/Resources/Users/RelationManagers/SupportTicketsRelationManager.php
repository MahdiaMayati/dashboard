<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Filament\Resources\SupportTickets\SupportTicketResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SupportTicketsRelationManager extends RelationManager
{
    protected static string $relationship = 'supportTickets';

    protected static ?string $relatedResource = SupportTicketResource::class;

    protected static ?string $title = 'Support tickets';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('subject')
                    ->limit(40),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('priority')
                    ->badge()
                    ->placeholder('—'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
