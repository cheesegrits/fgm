<?php

namespace App\Filament\Resources\Locations\Locations;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Locations\Pages\ListLocations;
use App\Filament\Resources\Locations\Pages\CreateLocation;
use App\Filament\Resources\Locations\Pages\ViewLocation;
use App\Filament\Resources\Locations\Pages\EditLocation;
use App\Filament\Resources\LocationResource\Pages;
use App\Models\Location;
use Cheesegrits\FilamentGoogleMaps\Actions\RadiusAction;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Cheesegrits\FilamentGoogleMaps\Filters\RadiusFilter;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;

//use App\Filament\Resources\LocationResource\RelationManagers;

class LocationResource extends Resource
{
    protected static ?string $model = Location::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->maxLength(256),
//                Forms\Components\TextInput::make('lat')
//                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
//                        $set('location', [
//                            'lat' => floatVal($state),
//                            'lng' => floatVal($get('lng')),
//                        ]);
//                    })
//                    ->lazy()
//                    ->maxLength(32),
//                Forms\Components\TextInput::make('lng')
//                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
//                        $set('location', [
//                            'lat' => floatval($get('lat')),
//                            'lng' => floatVal($state),
//                        ]);
//                    })
//                    ->lazy()
//                    ->maxLength(32),
                TextInput::make('street')
                    ->maxLength(255),
                TextInput::make('city')
                    ->maxLength(255),
                TextInput::make('state')
                    ->maxLength(255),
                TextInput::make('zip')
                    ->maxLength(255),
                TextInput::make('formatted_address')
                    ->maxLength(1024),

//                	            Geocomplete::make('formatted_address')
//                //                    ->types(['airport'])
//                //                    ->placeField('name')
////                		            ->isLocation()
////                		            ->updateLatLng()
//                		            ->reverseGeocode([
//                			            'city'   => '%L',
//                			            'zip'    => '%z',
//                			            'state'  => '%A1',
//                			            'street' => '%n %S',
//                		            ])
//                		            ->prefix('Choose:')
//                		            ->placeholder('Start typing an address ...')
//                		            ->maxLength(1024)
//                		            ->geolocate(),

                Map::make('location')
                    ->reactive()
                    ->afterStateUpdated(function ($state) {
                        $foo = 1;
                    })
                    ->drawingControl()
                    ->defaultLocation([39.526610, -107.727261])
                    ->mapControls([
                        'zoomControl' => true,
                    ])
                    ->debug()
                    ->clickable()
//                    ->layers([
//                        'https://googlearchive.github.io/js-v2-samples/ggeoxml/cta.kml',
//                    ])
                    ->autocomplete('formatted_address')
                    ->autocompleteReverse()
                    ->reverseGeocode([
                        'city'   => '%L',
                        'zip'    => '%z',
                        'state'  => '%A1',
                        'street' => '%n %S',
                    ])
                    ->geolocate()
//                    ->reverseGeocodeUsing(function (callable $set, array $results) {
//                        $set('city', 'foo bar');
//                    })
//                    ->placeUpdatedUsing(function (callable $set, array $place) {
//                        $set('city', 'foo wibble');
//                    })
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                //                Tables\Columns\TextColumn::make('lat'),
                //                Tables\Columns\TextColumn::make('lng'),
                TextColumn::make('street'),
                TextColumn::make('city')
                    ->searchable(),
                TextColumn::make('state')
                    ->searchable(),
                TextColumn::make('zip'),
                //                Tables\Columns\TextColumn::make('formatted_address'),
                //                MapColumn::make('location'),
                //                Tables\Columns\TextColumn::make('created_at')
                //                    ->dateTime(),
                //                Tables\Columns\TextColumn::make('updated_at')
                //                    ->dateTime(),
            ])
            ->filters([
                    TernaryFilter::make('processed'),
                    RadiusFilter::make('radius')
                        ->latitude('lat')
                        ->longitude('lng')
                        ->selectUnit()
                        ->section('Radius Search'),
                ]
            )
            ->filtersLayout(FiltersLayout::Dropdown)
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                RadiusAction::make('radius'),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
//            LocationResource\Widgets\LocationMapWidget::class,
//            LocationResource\Widgets\LocationMapTableWidget::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListLocations::route('/'),
            'create' => CreateLocation::route('/create'),
            'view'   => ViewLocation::route('/{record}'),
            'edit'   => EditLocation::route('/{record}/edit'),
        ];
    }
}
