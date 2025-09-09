<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\Volunteer;
use App\Models\ActivityRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition()
    {
        return [
            'volunteer_id' => function () {
                return Volunteer::factory()->create()->id;
            },
            'activity_id' => function () {
                return ActivityRequest::factory()->create()->id;
            },
            'rating' => $this->faker->numberBetween(1,5),
            'comment' => $this->faker->sentence(),
        ];
    }
}
