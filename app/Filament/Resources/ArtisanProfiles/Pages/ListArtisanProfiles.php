<?php

namespace App\Filament\Resources\ArtisanProfiles\Pages;

use App\Filament\Resources\ArtisanProfiles\ArtisanProfileResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListArtisanProfiles extends ListRecords
{
    protected static string $resource = ArtisanProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
