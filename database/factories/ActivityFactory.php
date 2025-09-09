<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    protected $model = \App\Models\Activity::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $start = $this->faker->dateTimeBetween('+3 days', '+60 days');
        $end = (clone $start)->modify('+2 days');

        return [
            'organizer_id' => \App\Models\Organizer::factory(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph,
            'registration_start_date' => now()->toDateString(),
            'registration_end_date' => $this->faker->dateTimeBetween('now', $start)->format('Y-m-d'),
            'activity_start_date' => $start->format('Y-m-d'),
            'activity_end_date' => $end->format('Y-m-d'),
            'location' => $this->faker->address,
            'thumbnail' => null,
        ];
    }
}
