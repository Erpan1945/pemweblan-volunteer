<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VolunteerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'       => $this->faker->name(),
            'email'      => $this->faker->unique()->safeEmail(),
            'password'   => bcrypt('password'),
            'gender'     => $this->faker->randomElement(['male', 'female', 'other']),
            'birth_date' => $this->faker->date(),
            'province'   => $this->faker->state(),
            'city'       => $this->faker->city(),
        ];
    }
}
