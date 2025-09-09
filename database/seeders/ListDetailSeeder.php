<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ListDetail;
use App\Models\ActivityList;
use Illuminate\Support\Facades\DB;

class ListDetailSeeder extends Seeder
{
    public function run(): void
    {
        $lists = ActivityList::factory(5)->create();

        // Ambil semua activity_id yang sudah ada di tabel activities
        $activities = DB::table('activities')->pluck('activity_id');

        foreach ($lists as $list) {
            foreach ($activities->random(min(3, $activities->count())) as $actId) {
                DB::table('list_details')->insert([
                    'list_id' => $list->id,
                    'activity_id' => $actId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
