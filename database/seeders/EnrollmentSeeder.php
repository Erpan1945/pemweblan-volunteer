<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enrollment;
use App\Models\Volunteer;
use App\Models\ActivityRequest;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        // Buat beberapa volunteer dan activity
        $volunteers = Volunteer::factory(5)->create();
        $activities = ActivityRequest::factory(5)->create();

        // Buat enrollments acak
        foreach ($volunteers as $vol) {
            foreach ($activities->random(3) as $act) { // tiap volunteer enroll di 3 activity
                Enrollment::factory()->create([
                    'volunteer_id' => $vol->id,
                    'activity_id' => $act->id,
                    'status' => 'approve', // tulis sebagai string
                ]);
            }
        }
    }
}
