<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DepartmentHour>
 */
class DepartmentHourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'day' => date("w",strtotime("now")),
            'init' => "08:00:00",
            'end' => "18:00:00",
            "department_id" => Department::factory(),
        ];
    }
}
