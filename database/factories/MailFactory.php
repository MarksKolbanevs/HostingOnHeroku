<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class MailFactory extends Factory
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
            'room_id' => User::inRandomOrder()->first()->id,
            'article' => $this->faker->word(),
            'text' => $this->faker->paragraph(),
            'size' => $this->faker->numberBetween(0, 20)
        ];
    }
}
