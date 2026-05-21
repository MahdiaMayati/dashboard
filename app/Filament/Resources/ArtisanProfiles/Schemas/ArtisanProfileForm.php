<?php

namespace App\Filament\Resources\ArtisanProfiles\Schemas;

use App\Enums\ArtisanApprovalStatus;
use App\Enums\UserRole;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ArtisanProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Artisan user')
                    ->relationship(
                        name: 'user',
                        titleAttribute: 'email',
                        modifyQueryUsing: fn ($query) => $query->where('role', UserRole::Artisan)
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('specialty_title')
                    ->maxLength(255),
                Textarea::make('bio')
                    ->rows(4)
                    ->columnSpanFull(),
                TextInput::make('address')
                    ->columnSpanFull(),
                TextInput::make('latitude')
                    ->numeric(),
                TextInput::make('longitude')
                    ->numeric(),
                TextInput::make('profile_image_path')
                    ->label('Profile image path')
                    ->maxLength(2048),
                TextInput::make('id_proof_path')
                    ->label('ID proof path')
                    ->maxLength(2048),
                TextInput::make('profession_proof_path')
                    ->label('Profession proof path')
                    ->maxLength(2048),
                Select::make('approval_status')
                    ->options(collect(ArtisanApprovalStatus::cases())->mapWithKeys(
                        fn (ArtisanApprovalStatus $s): array => [$s->value => (string) str($s->name)->headline()]
                    ))
                    ->required()
                    ->native(false),
                Textarea::make('approval_notes')
                    ->rows(2)
                    ->columnSpanFull(),
                Toggle::make('is_available')
                    ->default(true),
                Toggle::make('is_accepting_orders')
                    ->default(true),
                TextInput::make('average_rating')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(false)
                    ->visibleOn('edit'),
                TextInput::make('completed_orders_count')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(false)
                    ->visibleOn('edit'),
            ]);
    }
}
