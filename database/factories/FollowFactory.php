<?php

namespace Database\Factories;

use App\Models\Follow;
use App\Models\Organizer;
use App\Models\Volunteer;
use Illuminate\Database\Eloquent\Factories\Factory;

class FollowFactory extends Factory
{
    protected $model = Follow::class;

    public function definition()
    {
        return [
            // Pastikan selalu ada organizer_id dan volunteer_id valid
            'organizer_id' => function() {
                return Organizer::factory()->create()->id;
            },
            'volunteer_id' => function() {
                return Volunteer::factory()->create()->id;
            },
            'notification' => $this->faker->boolean(80), // default 80% true
        ];
    }
}
