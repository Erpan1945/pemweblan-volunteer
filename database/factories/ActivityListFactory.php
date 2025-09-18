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
            'volunteer_id' => Volunteer::inRandomOrder()->first()->volunteer_id ?? Volunteer::factory()->create()->volunteer_id,
            'name' => $this->faker->words(3, true),
        ];
    }
}
