<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FollowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $organizers = \App\Models\Organizer::all();
        $volunteers = \App\Models\Volunteer::all();

        foreach ($volunteers as $v) {
            $sample = $organizers->random(min(3, $organizers->count()));
            foreach ($sample as $org) {
                \App\Models\Follow::firstOrCreate([
                    'organizer_id' => $org->id,
                    'volunteer_id' => $v->id,
                ], ['notification' => true]);
            }
        }
    }
}
