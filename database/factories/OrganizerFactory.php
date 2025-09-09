<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'                 => $this->faker->company(),
            'email'                => $this->faker->unique()->companyEmail(),
            'phone_number'         => $this->faker->phoneNumber(),
            'password'             => bcrypt('password'),
            'date_of_establishment'=> $this->faker->date(),
            'description'          => $this->faker->paragraph(),
            'logo'                 => $this->faker->imageUrl(200,200,'logo'),
            'website'              => $this->faker->url(),
            'instagram'            => $this->faker->userName(),
            'tiktok'               => $this->faker->userName(),
            'province'             => $this->faker->state(),
            'city'                 => $this->faker->city(),
        ];
    }
}
