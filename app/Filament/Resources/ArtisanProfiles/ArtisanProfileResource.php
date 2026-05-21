<?php

namespace App\Filament\Resources\ArtisanProfiles;

use App\Filament\Resources\ArtisanProfiles\Pages\CreateArtisanProfile;
use App\Filament\Resources\ArtisanProfiles\Pages\EditArtisanProfile;
use App\Filament\Resources\ArtisanProfiles\Pages\ListArtisanProfiles;
use App\Filament\Resources\ArtisanProfiles\Pages\ViewArtisanProfile;
use App\Filament\Resources\ArtisanProfiles\RelationManagers\CategoriesRelationManager;
use App\Filament\Resources\ArtisanProfiles\RelationManagers\OrdersRelationManager;
use App\Filament\Resources\ArtisanProfiles\RelationManagers\ReviewsRelationManager;
use App\Filament\Resources\ArtisanProfiles\Schemas\ArtisanProfileForm;
use App\Filament\Resources\ArtisanProfiles\Schemas\ArtisanProfileInfolist;
use App\Filament\Resources\ArtisanProfiles\Tables\ArtisanProfilesTable;
use App\Models\ArtisanProfile;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class ArtisanProfileResource extends Resource
{
    protected static ?string $model = ArtisanProfile::class;

    protected static string|UnitEnum|null $navigationGroup = 'Artisans';

    protected static ?string $navigationLabel = 'Artisans';

    protected static ?int $navigationSort = 11;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    public static function form(Schema $schema): Schema
    {
        return ArtisanProfileForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ArtisanProfileInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ArtisanProfilesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            CategoriesRelationManager::class,
            OrdersRelationManager::class,
            ReviewsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListArtisanProfiles::route('/'),
            'create' => CreateArtisanProfile::route('/create'),
            'view' => ViewArtisanProfile::route('/{record}'),
            'edit' => EditArtisanProfile::route('/{record}/edit'),
        ];
    }

    public static function getRecordTitle(?Model $record): ?string
    {
        return $record?->user?->name;
    }
}
