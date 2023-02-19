<?php

namespace Database\Factories;

use App\Models\Geocode;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class GeocodeFactory extends Factory
{
    protected $model = Geocode::class;

    public function definition(): array
    {
        return [
            'name'              => $this->faker->name(),
            'lat'               => $this->faker->latitude(),
            'lng'               => $this->faker->longitude(),
            'street'            => $this->faker->streetName(),
            'city'              => $this->faker->city(),
            'state'             => $this->faker->word(),
            'zip'               => $this->faker->postcode(),
            'formatted_address' => $this->faker->address(),
            'processed'         => false,
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ];
    }

    public function withRealAddress(string $country, ?string $city = null): GeocodeFactory
    {

        $address = $this->faker->realAddress($country, $city);

        return $this->state([
            'lat'               => $address->getCoordinates()->getLatitude(),
            'lng'               => $address->getCoordinates()->getLongitude(),
            'street'            => $address->getStreetNumber() . ' ' . $address->getStreetName(),
            'city'              => $address->getLocality(),
            'state'             => $address->getAdminLevels()->get(1)->getName(),
            'zip'               => $address->getPostalCode(),
            'formatted_address' => $address->getFormattedAddress(),
        ]);
    }
}
