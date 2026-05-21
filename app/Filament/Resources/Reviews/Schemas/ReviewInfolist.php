<?php

namespace App\Filament\Resources\Reviews\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ReviewInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id'),
                TextEntry::make('order_id'),
                TextEntry::make('customer.name')->label('Reviewer'),
                TextEntry::make('customer.email'),
                TextEntry::make('artisanProfile.user.name')->label('Artisan'),
                TextEntry::make('rating'),
                TextEntry::make('comment')
                    ->columnSpanFull(),
                TextEntry::make('moderation_status')->badge(),
                TextEntry::make('moderatedBy.name')
                    ->label('Moderated by')
                    ->placeholder('—'),
                TextEntry::make('moderated_at')
                    ->dateTime()
                    ->placeholder('—'),
                TextEntry::make('created_at')->dateTime(),
            ]);
    }
}
