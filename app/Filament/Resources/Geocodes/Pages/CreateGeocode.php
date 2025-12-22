<?php

namespace App\Filament\Resources\Geocodes\Pages;

use App\Filament\Resources\Geocodes\GeocodeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGeocode extends CreateRecord
{
    protected static string $resource = GeocodeResource::class;
}
