<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trip;
use Carbon\Carbon;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Optional: Clear existing data before seeding (be careful in production)
        Trip::truncate();

        // Seed some trips
        Trip::create([
            'origin' => 'Manila',
            'destination' => 'Baguio',
            'travel_date' => Carbon::now()->addDays(2)->toDateString(),
            'travel_time' => '08:00:00',
        ]);

        Trip::create([
            'origin' => 'Clark',
            'destination' => 'La Union',
            'travel_date' => Carbon::now()->addDays(3)->toDateString(),
            'travel_time' => '14:00:00',
        ]);

        Trip::create([
            'origin' => 'Quezon City',
            'destination' => 'Vigan',
            'travel_date' => Carbon::now()->addDays(5)->toDateString(),
            'travel_time' => '06:30:00',
        ]);

        Trip::create([
            'origin' => 'San Fernando',
            'destination' => 'Bataan',
            'travel_date' => Carbon::now()->addDays(1)->toDateString(),
            'travel_time' => '10:00:00',
        ]);
    }
}
