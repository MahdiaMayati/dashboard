<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id'),
                TextEntry::make('status')->badge(),
                TextEntry::make('customer.name')->label('Customer'),
                TextEntry::make('customer.email'),
                TextEntry::make('artisanProfile.user.name')
                    ->label('Artisan')
                    ->placeholder('—'),
                TextEntry::make('serviceCategory.name')->label('Category'),
                TextEntry::make('title'),
                TextEntry::make('description')
                    ->columnSpanFull(),
                TextEntry::make('scheduled_at')
                    ->dateTime()
                    ->placeholder('—'),
                TextEntry::make('address')
                    ->columnSpanFull(),
                TextEntry::make('latitude')->placeholder('—'),
                TextEntry::make('longitude')->placeholder('—'),
                TextEntry::make('completion_notes')
                    ->columnSpanFull()
                    ->placeholder('—'),
                TextEntry::make('cancelled_reason')
                    ->columnSpanFull()
                    ->placeholder('—'),
                TextEntry::make('disputed_reason')
                    ->columnSpanFull()
                    ->placeholder('—'),
                TextEntry::make('completed_at')->dateTime()->placeholder('—'),
                TextEntry::make('cancelled_at')->dateTime()->placeholder('—'),
                TextEntry::make('created_at')->dateTime(),
                TextEntry::make('attachments_summary')
                    ->label('Attachment paths')
                    ->state(fn ($record) => $record->attachments->pluck('path')->implode(', ') ?: '—'),
            ]);
    }
}
