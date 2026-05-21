<?php

namespace App\Filament\Resources\Reviews\Schemas;

use App\Enums\ReviewModerationStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order_id')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(false)
                    ->visibleOn('edit'),
                TextInput::make('rating')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(5)
                    ->required(),
                Textarea::make('comment')
                    ->rows(4)
                    ->columnSpanFull(),
                Select::make('moderation_status')
                    ->options(collect(ReviewModerationStatus::cases())->mapWithKeys(
                        fn (ReviewModerationStatus $s): array => [$s->value => (string) str($s->name)->headline()]
                    ))
                    ->required()
                    ->native(false),
            ]);
    }
}
