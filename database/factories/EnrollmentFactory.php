<?php

namespace Database\Factories;

use App\Models\Enrollment;
use App\Models\Volunteer;
use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnrollmentFactory extends Factory
{
    protected $model = Enrollment::class;

    public function definition()
    {
        return [
            'volunteer_id' => function () {
                return Volunteer::factory()->create()->volunteer_id; // PK sesuai migration
            },
            'activity_id' => function () {
                return Activity::factory()->create()->activity_id; // harus ke Activity, bukan ActivityRequest
            },
            'status' => $this->faker->randomElement(['pending', 'approve', 'reject']),
        ];
    }
}
