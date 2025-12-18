<?php

namespace App\Filament\Resources\Locations\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Locations\Locations\LocationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLocations extends ListRecords
{
    protected static string $resource = LocationResource::class;

    protected static ?string $title = "All Locations";

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
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
