<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Organizer;

class ActivityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'organizer_id' => Organizer::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(3),
            'registration_start_date' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'registration_end_date' => $this->faker->dateTimeBetween('+3 weeks', '+4 weeks'),
            'activity_start_date' => $this->faker->dateTimeBetween('+5 weeks', '+6 weeks'),
            'activity_end_date' => $this->faker->dateTimeBetween('+6 weeks', '+7 weeks'),
            'location' => $this->faker->city(),
            'thumbnail' => $this->faker->imageUrl(),
            // --- INI BAGIAN YANG DIPERBAIKI TOTAL ---
            'status' => $this->faker->randomElement([
                'menunggu verifikasi admin', // Sesuai dengan controller
                'dipublikasikan',          // Sesuai dengan controller
                'ditolak'                  // Sesuai dengan controller
            ]),
        ];
    }
}