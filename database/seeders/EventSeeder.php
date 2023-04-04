<?php

namespace Database\Seeders;

use App\Models\Event;
use Database\Factories\EventFactory;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        Event::factory()->count(10)->create();
    }
}
