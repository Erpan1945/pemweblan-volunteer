<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Request>
 */
class RequestFactory extends Factory
{
    protected $model = \App\Models\RequestModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $start = $this->faker->dateTimeBetween('+5 days', '+30 days');
        $end = (clone $start)->modify('+1 day');

        return [
            'organizer_id' => \App\Models\Organizer::factory(), // will create if needed
            'status' => 'pending',
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph,
            'registration_start_date' => now()->format('Y-m-d'),
            'registration_end_date' => $this->faker->dateTimeBetween('now', $start)->format('Y-m-d'),
            'activity_start_date' => $start->format('Y-m-d'),
            'activity_end_date' => $end->format('Y-m-d'),
            'location' => $this->faker->address,
            'thumbnail' => null,
        ];
    }
}
