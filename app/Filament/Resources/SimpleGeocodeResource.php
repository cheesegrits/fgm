<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SimpleGeocodeResource\Pages;
use App\Models\Geocode;
use Cheesegrits\FilamentGoogleMaps\Columns\MapColumn;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Cheesegrits\FilamentGoogleMaps\Fields\WidgetMap;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class SimpleGeocodeResource extends Resource
{
    protected static ?string $model = Geocode::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->maxLength(256),
                Forms\Components\TextInput::make('lat')
                    ->maxLength(32),
                Forms\Components\TextInput::make('lng')
                    ->maxLength(32),
                Forms\Components\TextInput::make('street')
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->maxLength(255),
                Forms\Components\TextInput::make('state')
                    ->maxLength(255),
                Forms\Components\TextInput::make('zip')
                    ->maxLength(255),
                Geocomplete::make('location')
//                    ->types(['airport'])
//                    ->placeField('name')
                    ->isLocation()
                    ->updateLatLng()
                    ->reverseGeocode([
                        'city'  => '%L',
                        'zip'   => '%z',
                        'state' => '%A1',
                        //                        'street' => '%n z%S',
                    ])
                    ->reverseGeocodeUsing(function (callable $set, array $results) {
                        $set('street', $results['address_components'][1]['long_name']);
                        $set('city', 'I dun bin set');
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
                                'id' => $record->id,
                            ];
                        });

                        return $markers;
                    })
                    ->markerAction(Action::make('markerAction')
                        ->label('Details')
                        ->infolist([
                            Section::make([
                                TextEntry::make('name'),
                                TextEntry::make('street'),
                                TextEntry::make('city'),
                                TextEntry::make('state'),
                                TextEntry::make('zip'),
                                TextEntry::make('formatted_address'),
                            ])
                                ->columns(3),
                        ])
                        ->record(function (array $arguments) {
                            return array_key_exists('model_id', $arguments) ? Geocode::find($arguments['model_id']) : null;
                        })
                        ->modalSubmitAction(false)
                    )
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                MapColumn::make('location'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSimpleGeocodes::route('/'),
        ];
    }
}
