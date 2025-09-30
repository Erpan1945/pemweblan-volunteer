<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ActivityList;
use App\Models\Volunteer;

class ActivityListSeeder extends Seeder
{
    public function run()
    {
        // Buat volunteer dulu
        $volunteer = Volunteer::factory()->create();

        // Isi activity list dengan volunteer_id yang valid
        ActivityList::factory(10)->create([
            'volunteer_id' => Volunteer::factory(),
        ]);

    }
}
