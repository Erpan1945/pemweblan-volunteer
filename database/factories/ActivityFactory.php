<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Organizer;

class ActivityFactory extends Factory
{
    public function definition(): array
    {
        $organizerId = Organizer::query()->inRandomOrder()->value('organizer_id');

        if (!$organizerId) {
            $organizerId = Organizer::factory()->create()->organizer_id;
        }

        return [
            'organizer_id'            => $organizerId,
            'title'                   => $this->faker->sentence(),
            'description'             => $this->faker->paragraph(),
            'registration_start_date' => $this->faker->dateTimeBetween('now', '+1 week'),
            'registration_end_date'   => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'activity_start_date'     => $this->faker->dateTimeBetween('+2 weeks', '+3 weeks'),
            'activity_end_date'       => $this->faker->dateTimeBetween('+3 weeks', '+1 month'),
            'location'                => $this->faker->address(),
            'thumbnail'               => $this->faker->imageUrl(640, 480, 'event'),
        ];
    }
}
