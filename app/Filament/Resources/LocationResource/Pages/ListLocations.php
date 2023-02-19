<?php

namespace App\Filament\Resources\LocationResource\Pages;

use App\Filament\Resources\LocationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLocations extends ListRecords
{
    protected static string $resource = LocationResource::class;

    protected static ?string $title = "All Locations";

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
//            LocationResource\Widgets\LocationMapWidget::class,
        ];
    }

//    protected function getTableFiltersFormWidth(): string
//    {
//        return '4xl';
//    }
}
