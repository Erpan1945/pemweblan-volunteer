<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ActivityRequest;

class ActivityRequestSeeder extends Seeder
{
    public function run(): void
    {
        // otomatis bikin 10 activity request + organizer baru untuk tiap record
        ActivityRequest::factory(10)->create();
    }
}
