<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Volunteer;
use App\Models\Organizer;

class VolunteerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Volunteer::factory(30)->create();

        foreach (Volunteer::all() as $volunteer) {
            $organizers = \App\Models\Organizer::inRandomOrder()
                            ->take(2) 
                            ->pluck('organizer_id');

            $volunteer->organizers()->syncWithoutDetaching($organizers);
        }
    }
}
