<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Subscription;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'subscription_id' => Subscription::inRandomOrder()->first()->id,
            'name' => $this->faker->firstName(),
            'surname' => $this->faker->lastName(),
            'password' => $this->faker->word(),
            'phone' => $this->faker->e164PhoneNumber(),
            'email' => $this->faker->email(),
            'reserveEmail' => $this->faker->email()
        ];
    }
}
