<?php

namespace App\Filament\Resources\SimpleGeocodes\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\SimpleGeocodes\SimpleGeocodes\SimpleGeocodeResource;
use Cheesegrits\FilamentGoogleMaps\Concerns\InteractsWithMaps;
use Filament\Actions;
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
