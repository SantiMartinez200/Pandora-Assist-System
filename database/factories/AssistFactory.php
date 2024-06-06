<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assist>
 */
class AssistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
    $studentId = Student::inRandomOrder()->first()->id;
    return [
      'student_id' => $studentId,
      'created_at' => now(),
      'updated_at' => now(),
    ];
    }
}
