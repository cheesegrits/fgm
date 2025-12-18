<?php

namespace App\Filament\Resources\Geocodes\Pages;

use Filament\Actions\EditAction;
use App\Filament\Resources\Geocodes\Geocodes\GeocodeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGeocode extends ViewRecord
{
    protected static string $resource = GeocodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
