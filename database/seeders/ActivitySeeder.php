<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organizer;
use App\Models\Activity;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $organizers = Organizer::all();

        if ($organizers->count() == 0) {
            Organizer::factory(5)->create();
            $organizers = Organizer::all();
        }

        foreach ($organizers as $org) {
            Activity::factory(3)->create([
                'organizer_id' => $org->organizer_id,
            ]);
        }
    }
}
