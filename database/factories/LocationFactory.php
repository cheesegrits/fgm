<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Nonsapiens\RealAddressFactory\RealAddressFactory;

class LocationFactory extends Factory
{
    protected $model = Location::class;

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
            'description' => $this->faker->text(),
            'processed'         => false,
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ];
    }

    public function withRealAddressAndLatLng(string $country = 'united-states-of-america', ?string $city = null): LocationFactory
    {
//		$address = $this->faker->realAddress($country, $city);
        $f = new RealAddressFactory();
        $address = $f->make(1, $country, $city)->first();

        $state = $address->getAdminLevels()->get(1)->getName();
        $stateId = State::where(['state' => Str::of($state)->headline()->toString()])->first()?->id;

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

    public function withRealLatLng(string $country = 'united-states-of-america', ?string $city = null): LocationFactory
    {
//		$address = $this->faker->realAddress($country, $city);
        $f = new RealAddressFactory();
        $address = $f->make(1, $country, $city)->first();

        return $this->state([
            'lat'               => $address->getCoordinates()->getLatitude(),
            'lng'               => $address->getCoordinates()->getLongitude(),
            'street'            => null,
            'city'              => null,
            'state'             => null,
            'zip'               => null,
            'formatted_address' => null,
        ]);
    }

    public function withRealAddress(string $country = 'united-states-of-america', ?string $city = null): LocationFactory
    {
//		$address = $this->faker->realAddress($country, $city);
        $f = new RealAddressFactory();
        $address = $f->make(1, $country, $city)->first();

        return $this->state([
            'lat'               => null,
            'lng'               => null,
            'street'            => $address->getStreetNumber() . ' ' . $address->getStreetName(),
            'city'              => $address->getLocality(),
            'state'             => $address->getAdminLevels()->get(1)->getName(),
            'zip'               => $address->getPostalCode(),
            'formatted_address' => $address->getFormattedAddress(),
        ]);
    }
}
