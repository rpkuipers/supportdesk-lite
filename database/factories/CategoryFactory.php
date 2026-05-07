<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(['Werkplek', 'Netwerk', 'Microsoft 365', 'Hardware', 'Applicatie', 'Printer']).' '.fake()->numberBetween(1, 99),
            'description' => fake()->sentence(),
        ];
    }
}
