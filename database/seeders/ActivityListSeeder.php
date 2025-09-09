<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivityListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $volunteers = \App\Models\Volunteer::all();
        foreach ($volunteers as $v) {
            \App\Models\ActivityList::factory(2)->create(['volunteer_id' => $v->id]);
        }
    }
}
