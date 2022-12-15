<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'participant_1_id' => User::inRandomOrder()->first()->id,
            'participant_2_id' => User::inRandomOrder()->first()->id,
            'size' => $this->faker->numberBetween(0, 1000)
        ];
    }
}
