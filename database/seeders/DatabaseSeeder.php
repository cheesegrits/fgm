<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $real = $this->command->choice('Use real addresses?', ['no', 'yes'], 'yes');
        $count = $this->command->ask('Location count', '5');
        $extra = $this->command->ask('Extra count', '5');

        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name'  => 'Admin',
            'email' => 'admin@example.com',
        ]);

        $this->call(StateSeeder::class);
        $this->call(CountySeeder::class);
        $this->call(LocationSeeder::class, false, [
            'real' => $real === 'yes',
            'count' => (int) $count,
            'extra' => (int) $extra,
        ]);
//        $this->call(GeocodeSeeder::class);
    }
}
