<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        return [
            'name'       => $this->faker->name(),
            'location_id' => Location::inRandomOrder()->first()->id,
            'start_date' => Carbon::now(),
            'end_date'   => Carbon::now(),
        ];
    }
}
