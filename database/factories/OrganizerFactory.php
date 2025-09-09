<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organizer>
 */
class OrganizerFactory extends Factory
{
    protected $model = \App\Models\Organizer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'email' => $this->faker->unique()->companyEmail,
            'phone_number' => $this->faker->phoneNumber,
            'password' => bcrypt('password'),
            'date_of_establishment' => $this->faker->date(),
            'description' => $this->faker->paragraph,
            'logo' => null,
            'website' => $this->faker->url,
            'instagram' => $this->faker->userName,
            'tiktok' => $this->faker->userName,
            'province' => $this->faker->state,
            'city' => $this->faker->city,
        ];
    }
}
