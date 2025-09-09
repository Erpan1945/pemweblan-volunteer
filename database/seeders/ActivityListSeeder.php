<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ActivityList;
use App\Models\Volunteer;

class ActivityListSeeder extends Seeder
{
    public function run(): void
    {
        // Buat beberapa volunteer dulu
        $volunteers = Volunteer::factory(5)->create();

        // Buat 2 ActivityList per volunteer
        foreach ($volunteers as $vol) {
            ActivityList::factory(2)->create([
                'volunteer_id' => $vol->id
            ]);
        }
    }
}
