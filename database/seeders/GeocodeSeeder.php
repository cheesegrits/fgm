<?php

namespace Database\Seeders;

use App\Models\Geocode;
use Illuminate\Database\Seeder;

class GeocodeSeeder extends Seeder
{
	public function run()
	{
        for ($x = 0; $x <= 5; $x++)
        {
            Geocode::factory()->withRealAddress('united-states-of-america', 'New York, NY')->create();
            Geocode::factory()->withRealAddress('united-states-of-america', 'Chicago, IL')->create();
            Geocode::factory()->withRealAddress('united-states-of-america', 'San Francisco, CA')->create();
        }
	}
}
