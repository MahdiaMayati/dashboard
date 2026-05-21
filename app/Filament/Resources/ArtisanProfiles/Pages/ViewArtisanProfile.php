<?php

namespace App\Filament\Resources\ArtisanProfiles\Pages;

use App\Filament\Resources\ArtisanProfiles\ArtisanProfileResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewArtisanProfile extends ViewRecord
{
    protected static string $resource = ArtisanProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
