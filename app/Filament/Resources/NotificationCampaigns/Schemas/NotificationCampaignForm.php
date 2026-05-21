<?php

namespace App\Filament\Resources\NotificationCampaigns\Schemas;

use App\Enums\NotificationAudienceType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class NotificationCampaignForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Textarea::make('body')
                    ->required()
                    ->rows(8)
                    ->columnSpanFull(),
                Select::make('audience_type')
                    ->label('Audience')
                    ->options(collect(NotificationAudienceType::cases())->mapWithKeys(
                        fn (NotificationAudienceType $t): array => [$t->value => match ($t) {
                            NotificationAudienceType::AllCustomers => 'All customers',
                            NotificationAudienceType::AllArtisans => 'All approved artisans',
                            NotificationAudienceType::SingleUser => 'Single user',
                        }]
                    ))
                    ->required()
                    ->live()
                    ->native(false),
                Select::make('target_user_id')
                    ->label('Target user')
                    ->relationship(name: 'targetUser', titleAttribute: 'email')
                    ->searchable()
                    ->preload()
                    ->visible(fn ($get) => $get('audience_type') === NotificationAudienceType::SingleUser->value)
                    ->required(fn ($get) => $get('audience_type') === NotificationAudienceType::SingleUser->value),
            ]);
    }
}
