<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enrollment>
 */
class EnrollmentFactory extends Factory
{

    protected $model = \App\Models\Enrollment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'volunteer_id' => \App\Models\Volunteer::factory(),
            'activity_id' => \App\Models\Activity::factory(),
            'status' => $this->faker->randomElement(['pending','accepted','rejected']),
        ];
    }
}
