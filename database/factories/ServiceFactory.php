<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'provider_id' => User::factory(),
            'name' => fake()->words(2, true),
            'description' => fake()->sentence(),
            'duration_minutes' => fake()->randomElement([30, 45, 60]),
            'price' => fake()->randomFloat(2, 10, 100),
            'is_active' => true,
        ];
    }
}