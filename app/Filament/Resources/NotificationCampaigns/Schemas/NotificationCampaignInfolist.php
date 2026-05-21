<?php

namespace App\Filament\Resources\NotificationCampaigns\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class NotificationCampaignInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title')
                    ->columnSpanFull(),
                TextEntry::make('body')
                    ->columnSpanFull(),
                TextEntry::make('audience_type')
                    ->badge(),
                TextEntry::make('targetUser.email')
                    ->label('Target user')
                    ->placeholder('—'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('createdBy.name')
                    ->label('Created by'),
                TextEntry::make('sent_at')
                    ->dateTime()
                    ->placeholder('—'),
                TextEntry::make('created_at')
                    ->dateTime(),
            ]);
    }
}
