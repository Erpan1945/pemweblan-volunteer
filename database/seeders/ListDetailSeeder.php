<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ListDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lists = \App\Models\ActivityList::all();
        $activities = \App\Models\Activity::all();

        foreach ($lists as $list) {
            $sample = $activities->random(min(5, $activities->count()));
            foreach ($sample as $act) {
                \App\Models\ListDetail::firstOrCreate([
                    'list_id' => $list->id,
                    'activity_id' => $act->id,
                ]);
            }
        }
    }
}
