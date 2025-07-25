<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = Room::factory()->createMany([
            // ['location' => 'Magic Theatre', 'capacity'=> 500],
            ['location' => 'Lecture Theatre 1', 'capacity' => 250],
            ['location' => 'Lecture Theatre 2', 'capacity' => 250],
            ['location' => 'Lecture Theatre 3', 'capacity' => 250],
            ['location' => 'Lab 1', 'capacity' => 100],
            ['location' => 'Lab 2', 'capacity' => 100], 
            ['location' => 'Lab 3', 'capacity' => 100],
        ]);

    }
}
