<?php

namespace App\Filament\Resources\Locations\Pages;

use Filament\Actions\EditAction;
use Filament\Schemas\Schema;
use App\Filament\Resources\Locations\Locations\LocationResource;
use Cheesegrits\FilamentGoogleMaps\Infolists\MapEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

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
        return $infolist->schema([
            TextEntry::make('street'),
            TextEntry::make('city'),
            TextEntry::make('state'),
            TextEntry::make('zip'),
            MapEntry::make('location')
                ->columnSpan(2),
        ]);
    }
}
