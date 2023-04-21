<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Marcacion>
 */
class MarcacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $coords = fake()->localCoordinates();
        return [
            'user_id' => User::factory(),
            'datetime' => now()->setTimeFromTimeString("08:00:00"),
            'type' => "in",
            "position" => [
                "lat" => $coords["latitude"],
                "lng" => $coords["longitude"], 
            ]
        ];
    }
}
