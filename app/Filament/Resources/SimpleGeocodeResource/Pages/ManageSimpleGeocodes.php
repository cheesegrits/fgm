<?php

namespace App\Filament\Resources\SimpleGeocodeResource\Pages;

use App\Filament\Resources\SimpleGeocodeResource;
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
            Actions\CreateAction::make(),
        ];
    }
}
