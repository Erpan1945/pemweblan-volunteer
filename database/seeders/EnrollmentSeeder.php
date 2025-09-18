<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enrollment;
use App\Models\Volunteer;
use App\Models\Activity;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        // Buat beberapa volunteer dan activity
        $volunteers = Volunteer::factory(5)->create();
        $activities = Activity::factory(5)->create();

        // Buat enrollments acak
        foreach ($volunteers as $vol) {
            foreach ($activities->random(3) as $act) { // tiap volunteer enroll di 3 activity
                Enrollment::factory()->create([
                    'volunteer_id' => $vol->volunteer_id,  // pakai field PK sesuai migration
                    'activity_id'  => $act->activity_id,   // bukan $act->id
                    'status'       => 'approve',
                ]);
            }
        }
    }
}
