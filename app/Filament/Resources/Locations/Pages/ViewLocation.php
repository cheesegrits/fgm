<?php

namespace App\Filament\Resources\Locations\Pages;

use App\Filament\Resources\Locations\LocationResource;
use Cheesegrits\FilamentGoogleMaps\Infolists\MapEntry;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;

class ViewLocation extends ViewRecord
{
    protected static string $resource = LocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema->components([
            TextEntry::make('street'),
            TextEntry::make('city'),
            TextEntry::make('state'),
            TextEntry::make('zip'),
            MapEntry::make('location')
                ->columnSpan(2),
        ]);
    }
}
