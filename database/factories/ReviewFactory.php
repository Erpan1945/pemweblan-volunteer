<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\Volunteer;
use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            // Pastikan selalu menghasilkan PK yang valid (closure mengembalikan PK)
            'volunteer_id' => function () {
                return Volunteer::factory()->create()->volunteer_id;
            },
            'activity_id' => function () {
                return Activity::factory()->create()->activity_id;
            },
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->sentence(),
        ];
    }
}
