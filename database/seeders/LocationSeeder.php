<?php

namespace Database\Seeders;

use App\Models\County;
use App\Models\Geocode;
use App\Models\Location;
use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class LocationSeeder extends Seeder
{
    public function run($real = false, $count = 5, $extra = 5)
    {
        if ($real)
        {
            for ($x = 0; $x <= $count; $x++)
            {

                Location::factory()->withRealAddressAndLatLng('united-states-of-america', 'New York, NY')->create();
                Location::factory()->withRealAddressAndLatLng('united-states-of-america', 'Chicago, IL')->create();
            }

            for ($x = 0; $x <= $extra; $x++)
            {
                Location::factory()->withRealAddressAndLatLng('united-states-of-america', 'San Francisco, CA')->create();
                Location::factory()->withRealAddressAndLatLng('united-states-of-america', 'Los Angeles, CA')->create();
                Location::factory()->withRealAddressAndLatLng('united-states-of-america', 'San Diego, CA')->create();
                Location::factory()->withRealAddressAndLatLng('united-states-of-america', 'San Jose, CA')->create();
            }
        }
        else
        {
            Location::factory($count)->create();
        }

        State::all()->each(function ($state) {
            $state->update([
                'state' => Str::of($state->state)->lower()->title()->replace(' Of ', ' of ')->toString(),
            ]);
        });

        County::all()->each(function ($county) {
            $state = State::where(['state_code' => $county->state_code])->first();

            if ($state)
            {
                $county->update([
                    'state_id' => $state->id,
                ]);
            }
        });

        Location::all()->each(function ($location) {
            Geocode::create(
                Arr::except(
                    $location->toArray(),
                    ['description', 'state_id']
                )
            );

            $state = State::where(['state' => $location->state])->first();

            if ($state)
            {
                $location->update([
                    'state_id' => $state->id,
                ]);
            }
        });
    }
}
