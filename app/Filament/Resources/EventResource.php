<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Cheesegrits\FilamentGoogleMaps\Filters\RadiusFilter;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $slug = 'events';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),

                Select::make('location_id')
                    ->relationship('location', 'name')
                    ->searchable()
                    ->required(),

                DatePicker::make('start_date'),

                DatePicker::make('end_date'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('location.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('start_date')
                    ->date(),

                TextColumn::make('end_date')
                    ->date(),
            ])
            ->filters([
                RadiusFilter::make('radius')
                    ->attribute('location.location')
                    //->latitude('lat')
                    //->longitude('lng')
                    ->selectUnit()
                    ->section('Radius Search'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit'   => Pages\EditEvent::route('/{record}/edit'),
        ];
    }

    protected static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['location']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'location.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->location) {
            $details['Location'] = $record->location->name;
        }

        return $details;
    }
}
