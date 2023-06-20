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
            'title' => fake()->sentence(1),
            'subtitle' => fake()->sentence(4),
            'text' => fake()->text(300),
            'user_id' => 1,
            'publication_date' => fake()->dateTime(),
        ];
    }
}
