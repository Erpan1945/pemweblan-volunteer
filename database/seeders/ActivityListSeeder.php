<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ActivityList;
use App\Models\Activity;
use App\Models\Volunteer;

class ActivityListSeeder extends Seeder
{
    public function run()
    {
        // Buat volunteer dulu
        $volunteer = Volunteer::factory()->create();

        // Isi activity list dengan volunteer_id yang valid
        $lists = ActivityList::factory(10)->create([
            'volunteer_id' => $volunteer->volunteer_id,
        ]);

        // Ambil semua activity yang sudah ada
        $activities = Activity::factory(10)->create();

        // Untuk setiap list, attach beberapa activity random
        $lists->each(function ($list) use ($activities) {
            $randomActivities = $activities->random(rand(2, 4))->pluck('activity_id');
            // attach ke pivot
            $list->activities()->attach($randomActivities);
        });

    }
}
