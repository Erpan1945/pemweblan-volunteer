<?php

namespace Database\Factories;

use App\Models\ListDetail;
use App\Models\ActivityList;
use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;

class ListDetailFactory extends Factory
{
    protected $model = ListDetail::class;

    public function definition()
    {
        // Pastikan ada ActivityList dan Activity
        $activityList = ActivityList::inRandomOrder()->first() ?? ActivityList::factory()->create();
        $activity     = Activity::inRandomOrder()->first() ?? Activity::factory()->create();

        return [
            'list_id' => $activityList->list_id,
            'activity_id' => $activity->activity_id,
        ];
    }
}
