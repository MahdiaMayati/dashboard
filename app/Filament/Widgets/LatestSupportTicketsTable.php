<?php

namespace App\Filament\Widgets;

use App\Models\SupportTicket;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestSupportTicketsTable extends TableWidget
{
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Latest support tickets')
            ->query(
                SupportTicket::query()
                    ->with(['user'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('subject')->limit(40),
                TextColumn::make('user.email')->label('User'),
                TextColumn::make('status')->badge(),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
