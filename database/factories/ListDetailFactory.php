<?php

namespace Database\Factories;

use App\Models\ListDetail;
use App\Models\ActivityList;
use App\Models\ActivityRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class ListDetailFactory extends Factory
{
    protected $model = ListDetail::class;

    public function definition()
    {
        return [
            'list_id' => function() {
                return ActivityList::factory()->create()->id;
            },
            'activity_id' => function() {
                return ActivityRequest::factory()->create()->id;
            },
        ];
    }
}
