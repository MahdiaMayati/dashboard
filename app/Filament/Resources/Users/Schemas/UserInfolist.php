<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('email'),
                TextEntry::make('phone')
                    ->placeholder('—'),
                TextEntry::make('role')
                    ->badge(),
                TextEntry::make('account_status')
                    ->badge(),
                TextEntry::make('blocked_at')
                    ->dateTime()
                    ->placeholder('—'),
                TextEntry::make('suspended_at')
                    ->dateTime()
                    ->placeholder('—'),
                TextEntry::make('last_seen_at')
                    ->dateTime()
                    ->placeholder('—'),
                TextEntry::make('created_at')
                    ->dateTime(),
            ]);
    }
}
