<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Volunteer>
 */
class VolunteerFactory extends Factory
{

    protected $model = \App\Models\Volunteer::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'gender' => $this->faker->randomElement(['male','female','other']),
            'birth_date' => $this->faker->date('Y-m-d','2002-01-01'),
            'province' => $this->faker->state,
            'city' => $this->faker->city,
        ];
    }
}
