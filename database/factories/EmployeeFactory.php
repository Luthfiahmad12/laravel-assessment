<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'avatar' => fake()->imageUrl(),
            'address' => fake()->address(),
            'hire_date' => fake()->date('d/m/Y', 'now'),
            'skills' => json_encode(fake()->words(8))
        ];
    }
}
