<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(12),
            'subtitle' => fake()->sentence(6),
            'text' => fake()->text(5000),
            'author' => fake()->name,
            'publication_date' => fake()->dateTime(),
        ];
    }
}
