<?php

namespace Database\Factories;

use App\Models\ActivityList;
use App\Models\Volunteer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityListFactory extends Factory
{
    protected $model = ActivityList::class;

    public function definition()
    {
        return [
            // Pastikan selalu ada volunteer_id valid
            'volunteer_id' => function() {
                return Volunteer::factory()->create()->id;
            },
            'name' => $this->faker->sentence(3),
        ];
    }
}
