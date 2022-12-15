<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Room;

class RoomCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'room_id' => Room::inRandomOrder()->first()->id,
            'important' => $this->faker->boolean(),
            'deferred' => $this->faker->boolean(),
            'spam' => $this->faker->boolean(),
        ];
    }
}
