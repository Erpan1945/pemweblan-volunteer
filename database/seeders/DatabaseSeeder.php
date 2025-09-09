<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Volunteer;
use App\Models\Organizer;
use App\Models\Admin;
use App\Models\Activity;
use App\Models\ActivityRequest;
use App\Models\Review;
use App\Models\ActivityList;
use App\Models\Follow;
use App\Models\Enrollment;
use App\Models\ListDetail;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            OrganizerSeeder::class,
            VolunteerSeeder::class,
            ActivitySeeder::class,
            ActivityRequestSeeder::class,
            ActivityListSeeder::class,
            FollowSeeder::class,
            EnrollmentSeeder::class,
            ReviewSeeder::class,
            ListDetailSeeder::class,
        ]);
    }
}
