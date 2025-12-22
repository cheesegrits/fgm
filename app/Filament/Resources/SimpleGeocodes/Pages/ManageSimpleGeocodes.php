<?php

namespace App\Filament\Resources\SimpleGeocodes\Pages;

use App\Filament\Resources\SimpleGeocodes\SimpleGeocodeResource;
use Cheesegrits\FilamentGoogleMaps\Concerns\InteractsWithMaps;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageSimpleGeocodes extends ManageRecords
{
    use InteractsWithMaps;

    protected static string $resource = SimpleGeocodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
