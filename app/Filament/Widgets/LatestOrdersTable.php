<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestOrdersTable extends TableWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Latest orders')
            ->query(
                Order::query()
                    ->with(['customer', 'serviceCategory', 'artisanProfile.user'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('status')->badge(),
                TextColumn::make('customer.name')->label('Customer'),
                TextColumn::make('serviceCategory.name')->label('Category'),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
