<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Room;
use App\Models\Mail;

class MailCategoryFactory extends Factory
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
            'mail_id' => Mail::inRandomOrder()->first()->id,
            'unread' => $this->faker->boolean(),
            'important' => $this->faker->boolean()
        ];
    }
}
