<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            'location'         => $this->faker->word,
            'capacity'         => $this->faker->numberBetween(10, 100),
        ];
    }

}
