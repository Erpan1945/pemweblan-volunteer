<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            AdminSeeder::class,
            OrganizerSeeder::class,
            VolunteerSeeder::class,
            ActivitySeeder::class,
            RequestSeeder::class,
            EnrollmentSeeder::class,
            ReviewSeeder::class,
            FollowSeeder::class,
            ActivityListSeeder::class,
            ListDetailSeeder::class,
        ]);
    }
}
