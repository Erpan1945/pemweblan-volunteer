<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizers = \App\Models\Organizer::all();
        if ($organizers->count() == 0) {
            \App\Models\Organizer::factory(5)->create();
            $organizers = \App\Models\Organizer::all();
        }

        foreach ($organizers as $org) {
            \App\Models\Activity::factory(3)->create(['organizer_id' => $org->id]);
        }
    }
}
