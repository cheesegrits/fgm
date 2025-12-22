<?php

namespace App\Filament\Resources\Geocodes\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Geocodes\GeocodeResource;
use Filament\Resources\Pages\ListRecords;

class ListGeocodes extends ListRecords
{
    protected static string $resource = GeocodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
