<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Volunteer;
use App\Models\Activity;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua volunteer & activity yang sudah ada
        $volunteers = Volunteer::all();
        $activities = Activity::all();

        // Jika kosong, buat data dummy dulu
        if ($volunteers->isEmpty()) {
            $volunteers = Volunteer::factory(5)->create();
        }
        if ($activities->isEmpty()) {
            $activities = Activity::factory(5)->create();
        }

        // Per volunteer buat 1-2 review (pastikan menggunakan PK nama yang benar)
        foreach ($volunteers as $vol) {
            $n = rand(1, 2);
            for ($i = 0; $i < $n; $i++) {
                Review::factory()->create([
                    // gunakan attribute primary key sesuai migration
                    'volunteer_id' => $vol->volunteer_id ?? $vol->getKey(),
                    'activity_id'  => $activities->random()->activity_id,
                ]);
            }
        }
    }
}
