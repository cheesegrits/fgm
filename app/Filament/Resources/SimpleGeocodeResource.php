<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SimpleGeocodeResource\Pages;
use App\Filament\Resources\SimpleGeocodeResource\RelationManagers;
use App\Models\Geocode;
use Cheesegrits\FilamentGoogleMaps\Columns\MapColumn;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                        'city'   => '%L',
                        'zip'    => '%z',
                        'state'  => '%A1',
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
