<?php

namespace Database\Factories;

use App\Models\ActivityRequest;
use App\Models\Organizer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityRequestFactory extends Factory
{
    protected $model = ActivityRequest::class;

    public function definition(): array
    {
        return [
            'organizer_id' => Organizer::factory(),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'registration_start_date' => $this->faker->dateTimeBetween('+1 days', '+5 days'),
            'registration_end_date' => $this->faker->dateTimeBetween('+6 days', '+10 days'),
            'activity_start_date' => $this->faker->dateTimeBetween('+11 days', '+15 days'),
            'activity_end_date' => $this->faker->dateTimeBetween('+16 days', '+20 days'),
            'location' => $this->faker->address,
            'thumbnail' => $this->faker->imageUrl(640, 480, 'event', true),
        ];
    }

}   
