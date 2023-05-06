<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LoyaltyProgram>
 */
class LoyaltyProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => Str::title($this->faker->words(4, true)),
            'description' => $this->faker->paragraph(10),
            'photo' => $this->faker->imageUrl(),
        ];
    }
}
