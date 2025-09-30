<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ListDetail;
use App\Models\ActivityList;
use App\Models\Activity;

class ListDetailSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada ActivityList
        $lists = ActivityList::factory(5)->create();

        // Pastikan ada Activity
        $activities = Activity::all();
        if ($activities->isEmpty()) {
            $activities = Activity::factory(10)->create();
        }

        foreach ($lists as $list) {
            $randomActivities = $activities->random(min(3, $activities->count()));

            foreach ($randomActivities as $act) {
                ListDetail::create([
                    'list_id'     => $list->list_id,     // gunakan primary key yang benar
                    'activity_id' => $act->activity_id, // gunakan primary key yang benar
                ]);
            }
        }
    }
}
