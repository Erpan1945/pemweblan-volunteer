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
        // Pastikan ada organizer & volunteer
        $organizers = Organizer::all();
        if ($organizers->count() === 0) {
            $organizers = Organizer::factory(5)->create();
        }

        $volunteers = Volunteer::all();
        if ($volunteers->count() === 0) {
            $volunteers = Volunteer::factory(5)->create();
        }

        // Buat follow
        foreach ($volunteers as $vol) {
            $randomOrg = $organizers->random();

            Follow::create([
                'organizer_id' => $randomOrg->organizer_id,
                'volunteer_id' => $vol->volunteer_id,
                'notification' => true,
            ]);
        }
    }
}
