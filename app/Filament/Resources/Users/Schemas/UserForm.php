<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\AccountStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('phone')
                    ->tel()
                    ->maxLength(32),
                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->required(fn ($livewire): bool => $livewire instanceof CreateRecord)
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->dehydrateStateUsing(fn (?string $state): ?string => filled($state) ? Hash::make($state) : null),
                Select::make('account_status')
                    ->options(collect(AccountStatus::cases())->mapWithKeys(
                        fn (AccountStatus $s): array => [$s->value => (string) str($s->name)->headline()]
                    ))
                    ->required()
                    ->native(false),
            ]);
    }
}
