<?php

namespace App\Filament\Resources\Geocodes\Geocodes;

use App\Filament\Resources\Geocodes\Pages\CreateGeocode;
use App\Filament\Resources\Geocodes\Pages\EditGeocode;
use App\Filament\Resources\Geocodes\Pages\ListGeocodes;
use App\Filament\Resources\Geocodes\Pages\ViewGeocode;
use App\Models\Geocode;
use Cheesegrits\FilamentGoogleMaps\Actions\StaticMapAction;
use Cheesegrits\FilamentGoogleMaps\Actions\WidgetMapAction;
use Cheesegrits\FilamentGoogleMaps\Columns\MapColumn;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Cheesegrits\FilamentGoogleMaps\Fields\WidgetMap;
use Cheesegrits\FilamentGoogleMaps\Filters\RadiusFilter;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class GeocodeResource extends Resource
{
    protected static ?string $model = Geocode::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->maxLength(256),
                //                Forms\Components\TextInput::make('lat')
                //                    ->maxLength(32),
                //                Forms\Components\TextInput::make('lng')
                //                    ->maxLength(32),
                TextInput::make('street')
                    ->maxLength(255),
                TextInput::make('city')
                    ->maxLength(255),
                TextInput::make('state')
                    ->maxLength(255),
                TextInput::make('zip')
                    ->maxLength(255),
                Geocomplete::make('formatted_address'),
                Geocomplete::make('location')
                    //                    ->types(['airport'])
                    //                    ->placeField('name')
                    ->geocodeOnLoad()
                    ->isLocation()
//                    ->updateLatLng()
                    ->reverseGeocode([
                        'city'  => '%L',
                        'zip'   => '%z',
                        'state' => '%A1',
                        //                        'street' => '%n z%S',
                    ])
                    ->reverseGeocodeUsing(function (callable $set, array $results) {
                        $set('street', $results['address_components'][1]['long_name']);
                    })
                    ->prefix('Choose:')
                    ->placeholder('Start typing an address ...')
                    ->maxLength(1024)
                    ->geolocate(),

                WidgetMap::make('widget_map')
                    ->mapControls([
                        'zoomControl' => true,
                    ])
                    ->markers(function ($model) {
                        $markers      = [];
                        $records      = Geocode::all();
                        $latLngFields = $model::getLatLngAttributes();

                        $records->each(function (Model $record) use (&$markers, $latLngFields) {
                            $latField = $latLngFields['lat'];
                            $lngField = $latLngFields['lng'];

                            $markers[] = [
                                'location' => [
                                    'lat' => $record->{$latField} ? round(floatval($record->{$latField}), 8) : 0,
                                    'lng' => $record->{$lngField} ? round(floatval($record->{$lngField}), 8) : 0,
                                ],
                            ];
                        });

                        return $markers;
                    })
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
                //
                //                Tables\Columns\TextColumn::make('lng'),

                TextColumn::make('street'),

                TextColumn::make('city')
                    ->searchable(),

                TextColumn::make('state')
                    ->searchable(),

                TextColumn::make('zip'),

                //                Tables\Columns\TextColumn::make('formatted_address')
                //                    ->wrap()
                //                    ->searchable(),

                MapColumn::make('location'),
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
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
                StaticMapAction::make(),
                WidgetMapAction::make(),
            ]);

    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListGeocodes::route('/'),
            'create' => CreateGeocode::route('/create'),
            'view'   => ViewGeocode::route('/{record}'),
            'edit'   => EditGeocode::route('/{record}/edit'),
        ];
    }
}
