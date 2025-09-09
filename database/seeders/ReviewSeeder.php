<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Volunteer;
use App\Models\ActivityRequest;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $volunteers = Volunteer::factory(5)->create();
        $activities = ActivityRequest::factory(5)->create();

        foreach ($volunteers as $vol) {
            foreach ($activities->random(3) as $act) {
                Review::factory()->create([
                    'volunteer_id' => $vol->id,
                    'activity_id' => $act->id,
                ]);
            }
        }
    }
}
