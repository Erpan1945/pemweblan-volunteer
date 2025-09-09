<?php

namespace Database\Factories;

use App\Models\ActivityRequest;
use App\Models\Organizer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityRequestFactory extends Factory
{
    protected $model = ActivityRequest::class;

    public function definition()
    {
        return [
            'organizer_id' => function() {
                return Organizer::factory()->create()->id; // pastikan selalu ada
            },
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'registration_start_date' => $this->faker->dateTimeBetween('now', '+1 week'),
            'registration_end_date' => $this->faker->dateTimeBetween('+1 week', '+2 week'),
            'activity_start_date' => $this->faker->dateTimeBetween('+2 week', '+3 week'),
            'activity_end_date' => $this->faker->dateTimeBetween('+3 week', '+4 week'),
            'location' => $this->faker->address(),
            'thumbnail' => $this->faker->imageUrl(640, 480),
        ];
    }
}
