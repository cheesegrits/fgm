<?php

namespace App\Filament\Resources\Geocodes\Pages;

use App\Filament\Resources\Geocodes\Geocodes\GeocodeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGeocode extends CreateRecord
{
    protected static string $resource = GeocodeResource::class;
}
