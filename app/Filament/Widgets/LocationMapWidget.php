<?php

namespace App\Filament\Widgets;

use App\Models\Location;
use Cheesegrits\FilamentGoogleMaps\Widgets\MapWidget;
use Filament\Actions\Action;
use Filament\Infolists\Components\Card;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;

class LocationMapWidget extends MapWidget
{
	protected static ?string $heading = 'Map';

	protected static ?int $sort = 1;

	protected static ?string $pollingInterval = null;

	protected static ?bool $clustering = true;

	protected static ?bool $fitToBounds = true;

	protected static ?int $zoom = 18;

	protected static ?string $markerAction = 'markerAction';

    protected function getLayers(): array
    {
        return [
            'https://googlearchive.github.io/js-v2-samples/ggeoxml/cta.kml'
        ];
    }

	protected function getData(): array
	{
		/**
		 * You can use whatever query you want here, as long as it produces a set of records with your
		 * lat and lng fields in them.
		 */
		$locations = Location::limit(500)->get();

		$data = [];

		foreach ($locations as $location) {
			/**
			 * Each element in the returned data must be an array
			 * containing a 'location' array of 'lat' and 'lng',
			 * and a 'label' string (optional but reccomended by Google
			 * for accessibility.
			 */
			$data[] = [
				'location' => [
					'lat' => $location->lat ? round(floatval($location->lat), static::$precision) : 0,
					'lng' => $location->lng ? round(floatval($location->lng), static::$precision) : 0,
				],

				'label' => $location->lat . ',' . $location->lng,

				'id' => $location->getKey(),

				/**
				 * Optionally you can provide custom icons for the map markers,
				 * either as scalable SVG's, or PNG, which doesn't support scaling.
				 * If you don't provide icons, the map will use the standard Google marker pin.
				 */
//				'icon' => [
//					'url' => url('images/dealership.svg'),
//					'type' => 'svg',
//					'scale' => [35,35],
//				],
			];
		}

		return $data;
	}

    public function getConfig(): array
    {
        $config = parent::getConfig();

        // Disable points of interest
        $config['mapConfig']['styles'] = [
            [
                'featureType' => 'poi',
                'elementType' => 'labels',
                'stylers' => [
                    ['visibility' => 'off'],
                ],
            ],
        ];

        return $config;
    }

	public function markerAction(): Action
	{
		return Action::make('markerAction')
			->label('Details')
			->infolist([
				Card::make([
					TextEntry::make('name'),
					TextEntry::make('street'),
					TextEntry::make('city'),
					TextEntry::make('state'),
					TextEntry::make('zip'),
					TextEntry::make('formatted_address'),
				])
				->columns(3)
			])
			->record(function (array $arguments) {
				return array_key_exists('model_id', $arguments) ? Location::find($arguments['model_id']) : null;
			})
			->modalFooterActions([]);
	}

}
