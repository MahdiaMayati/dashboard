<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Enums\OrderStatus;
use App\Enums\UserRole;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('customer_id')
                    ->relationship(
                        name: 'customer',
                        titleAttribute: 'email',
                        modifyQueryUsing: fn ($q) => $q->where('role', UserRole::Customer)
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('artisan_profile_id')
                    ->relationship(name: 'artisanProfile', titleAttribute: 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->user?->name.' (#'.$record->id.')')
                    ->searchable()
                    ->preload(),
                Select::make('service_category_id')
                    ->relationship(name: 'serviceCategory', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('status')
                    ->options(collect(OrderStatus::cases())->mapWithKeys(
                        fn (OrderStatus $s): array => [$s->value => (string) str($s->name)->headline()]
                    ))
                    ->required()
                    ->native(false),
                TextInput::make('title')
                    ->maxLength(255),
                Textarea::make('description')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
                DateTimePicker::make('scheduled_at'),
                TextInput::make('address')
                    ->columnSpanFull(),
                TextInput::make('latitude')
                    ->numeric(),
                TextInput::make('longitude')
                    ->numeric(),
                Textarea::make('completion_notes')
                    ->rows(2)
                    ->columnSpanFull(),
                Textarea::make('cancelled_reason')
                    ->rows(2)
                    ->columnSpanFull(),
                Textarea::make('disputed_reason')
                    ->rows(2)
                    ->columnSpanFull(),
                DateTimePicker::make('completed_at'),
                DateTimePicker::make('cancelled_at'),
            ]);
    }
}
