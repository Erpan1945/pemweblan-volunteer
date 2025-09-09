<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Follow;
use App\Models\Organizer;
use App\Models\Volunteer;

class FollowSeeder extends Seeder
{
    public function run(): void
    {
        // Buat beberapa organizer & volunteer dulu
        $organizers = Organizer::factory(5)->create();
        $volunteers = Volunteer::factory(5)->create();

        // Buat beberapa Follow acak
        foreach ($volunteers as $vol) {
            // setiap volunteer follow 2 organizer
            foreach ($organizers->random(2) as $org) {
                Follow::factory()->create([
                    'organizer_id' => $org->id,
                    'volunteer_id' => $vol->id,
                ]);
            }
        }
    }
}
