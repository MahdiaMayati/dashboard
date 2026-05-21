<?php

namespace App\Filament\Widgets;

use App\Models\ServiceCategory;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class TopServiceCategoriesTable extends TableWidget
{
    protected static ?int $sort = 6;

    protected int|string|array $columnSpan = [
        'md' => 2,
        'xl' => 2,
    ];

    public function table(Table $table): Table
    {
        return $table
            ->heading('Top service categories')
            ->query(
                ServiceCategory::query()
                    ->withCount('orders')
                    ->orderByDesc('orders_count')
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('orders_count')
                    ->label('Orders')
                    ->sortable(),
            ])
            ->defaultSort('orders_count', 'desc');
    }
}
