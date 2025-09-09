<?php

namespace Database\Factories;

use App\Models\Enrollment;
use App\Models\Volunteer;
use App\Models\ActivityRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnrollmentFactory extends Factory
{
    protected $model = Enrollment::class;

    public function definition()
    {
        return [
            'volunteer_id' => function () {
                return Volunteer::factory()->create()->id;
            },
            'activity_id' => function () {
                return ActivityRequest::factory()->create()->id;
            },
            // Pastikan sesuai ENUM
            'status' => $this->faker->randomElement(['pending', 'approve', 'reject']),
        ];
    }
}
