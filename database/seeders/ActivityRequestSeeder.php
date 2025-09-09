<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ActivityRequest;
use App\Models\Organizer;

class ActivityRequestSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 5 organizer
        $organizers = Organizer::factory(5)->create();

        // Buat 2 ActivityRequest per organizer
        foreach ($organizers as $org) {
            ActivityRequest::factory(2)->create([
                'organizer_id' => $org->id
            ]);
        }
    }
}
