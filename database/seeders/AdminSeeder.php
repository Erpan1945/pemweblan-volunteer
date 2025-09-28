<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        \App\Models\Admin::truncate();

        \App\Models\Admin::create([
            'name' => 'kelompok3',
            'email' => 'kelompok3@example.com',
            'password' => Hash::make('kelompok3'), // <-- passwordnya adalah 'kelompok3'
        ]);

        \App\Models\Admin::factory()->count(2)->create();
    }
}
