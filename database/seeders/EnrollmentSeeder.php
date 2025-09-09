<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $volunteers = \App\Models\Volunteer::all();
        $activities = \App\Models\Activity::all();

        foreach ($activities as $activity) {
            $sample = $volunteers->random(min(6, $volunteers->count()));
            foreach ($sample as $v) {
                \App\Models\Enrollment::firstOrCreate([
                    'volunteer_id' => $v->id,
                    'activity_id' => $activity->id,
                ], [
                    'status' => 'pending'
                ]);
            }
        }
    }
}
