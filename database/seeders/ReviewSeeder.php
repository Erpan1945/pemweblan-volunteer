<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $volunteers = \App\Models\Volunteer::all();
        $activities = \App\Models\Activity::all();

        if ($volunteers->count() && $activities->count()) {
            foreach ($activities as $activity) {
                $sample = $volunteers->random(min(5, $volunteers->count()));
                foreach ($sample as $v) {
                    \App\Models\Review::factory()->create([
                        'activity_id' => $activity->id,
                        'volunteer_id' => $v->id,
                    ]);
                }
            }
        }
    }
}
