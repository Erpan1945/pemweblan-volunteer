<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


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
            EnrollmentSeeder::class,
            ReviewSeeder::class,
            ListDetailSeeder::class,
            UserSeeder::class,
        ]);
    }
}
