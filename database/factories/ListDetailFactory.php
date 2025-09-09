<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ListDetail>
 */
class ListDetailFactory extends Factory
{

    protected $model = \App\Models\ListDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'list_id' => \App\Models\ActivityList::factory(),
            'activity_id' => \App\Models\Activity::factory(),
        ];
    }
}
