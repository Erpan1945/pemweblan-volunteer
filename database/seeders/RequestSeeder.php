<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat beberapa requests, tapi agar organizer tidak terduplikasi: ambil organizer existing
        $organizers = \App\Models\Organizer::all();
        if ($organizers->count() == 0) {
            \App\Models\Organizer::factory(5)->create();
            $organizers = \App\Models\Organizer::all();
        }

        foreach ($organizers as $org) {
            \App\Models\RequestModel::factory(2)->create(['organizer_id' => $org->id]);
        }
    }
}
