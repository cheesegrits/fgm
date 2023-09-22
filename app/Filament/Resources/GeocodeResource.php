<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GeocodeResource\Pages;
use App\Filament\Resources\GeocodeResource\RelationManagers;
use App\Models\Geocode;
use Cheesegrits\FilamentGoogleMaps\Actions\StaticMapAction;
use Cheesegrits\FilamentGoogleMaps\Actions\WidgetMapAction;
use Cheesegrits\FilamentGoogleMaps\Columns\MapColumn;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Cheesegrits\FilamentGoogleMaps\Fields\WidgetMap;
use Cheesegrits\FilamentGoogleMaps\Filters\RadiusFilter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class GeocodeResource extends Resource
{
    protected static ?string $model = Geocode::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->maxLength(256),
//                Forms\Components\TextInput::make('lat')
//                    ->maxLength(32),
//                Forms\Components\TextInput::make('lng')
//                    ->maxLength(32),
                Forms\Components\TextInput::make('street')
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->maxLength(255),
                Forms\Components\TextInput::make('state')
                    ->maxLength(255),
                Forms\Components\TextInput::make('zip')
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
                        $markers = [];
                        $records = Geocode::all();
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
                    ->columnSpan(2)
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                //                Tables\Columns\TextColumn::make('lat'),
                //
                //                Tables\Columns\TextColumn::make('lng'),

                Tables\Columns\TextColumn::make('street'),

                Tables\Columns\TextColumn::make('city')
                    ->searchable(),

                Tables\Columns\TextColumn::make('state')
                    ->searchable(),

                Tables\Columns\TextColumn::make('zip'),

                //                Tables\Columns\TextColumn::make('formatted_address')
                //                    ->wrap()
                //                    ->searchable(),

                MapColumn::make('location'),
            ])
            ->filters([
                    Tables\Filters\TernaryFilter::make('processed'),
                    RadiusFilter::make('radius')
                        ->latitude('lat')
                        ->longitude('lng')
                        ->selectUnit()
                        ->section('Radius Search'),
                ]
            )
            ->filtersLayout(FiltersLayout::Dropdown)
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index'  => Pages\ListGeocodes::route('/'),
            'create' => Pages\CreateGeocode::route('/create'),
            'view'   => Pages\ViewGeocode::route('/{record}'),
            'edit'   => Pages\EditGeocode::route('/{record}/edit'),
        ];
    }
}
