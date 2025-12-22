<?php

namespace App\Filament\Resources\Geocodes\Pages;

use App\Filament\Resources\Geocodes\GeocodeResource;
use Cheesegrits\FilamentGoogleMaps\Concerns\InteractsWithMaps;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditGeocode extends EditRecord
{
    use InteractsWithMaps;

    protected static string $resource = GeocodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
