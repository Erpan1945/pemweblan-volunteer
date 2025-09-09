<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Follow>
 */
class FollowFactory extends Factory
{

    protected $model = \App\Models\Follow::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'organizer_id' => \App\Models\Organizer::factory(),
            'volunteer_id' => \App\Models\Volunteer::factory(),
            'notification' => $this->faker->boolean(80),
        ];
    }
}
