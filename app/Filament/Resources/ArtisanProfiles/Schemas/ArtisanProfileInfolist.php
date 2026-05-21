<?php

namespace App\Filament\Resources\ArtisanProfiles\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ArtisanProfileInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name'),
                TextEntry::make('user.email'),
                TextEntry::make('specialty_title'),
                TextEntry::make('bio')
                    ->columnSpanFull(),
                TextEntry::make('address'),
                TextEntry::make('approval_status')
                    ->badge(),
                TextEntry::make('approval_notes')
                    ->columnSpanFull(),
                TextEntry::make('is_available')
                    ->badge(),
                TextEntry::make('is_accepting_orders')
                    ->badge(),
                TextEntry::make('average_rating'),
                TextEntry::make('completed_orders_count'),
                ImageEntry::make('profile_image_path')
                    ->label('Profile image')
                    ->disk('public')
                    ->height(120)
                    ->visible(fn ($record) => filled($record->profile_image_path)),
                ImageEntry::make('id_proof_path')
                    ->label('ID proof')
                    ->disk('public')
                    ->height(160)
                    ->visible(fn ($record) => filled($record->id_proof_path)),
                ImageEntry::make('profession_proof_path')
                    ->label('Profession proof')
                    ->disk('public')
                    ->height(160)
                    ->visible(fn ($record) => filled($record->profession_proof_path)),
            ]);
    }
}
