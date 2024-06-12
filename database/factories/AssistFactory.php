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
    $studentDni = Student::inRandomOrder()->first()->dni_student;
    return [
      'student_dni' => $studentDni,
      'created_at' => now(),
      'updated_at' => now(),
    ];
    }
}
