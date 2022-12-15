<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class StorageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $capacity = $this->faker->numberBetween(5, 50);
        $used = $this->faker->numberBetween(5, $capacity);
        $empty = $capacity - $used;
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'capacity' => $capacity,
            'used' => $used,
            'empty' => $empty
        ];
    }
}
