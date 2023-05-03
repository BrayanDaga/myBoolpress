<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InfoPost>
 */
class InfoPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_status' => fake()->randomElement(['public', 'private', 'draft']),
            'comment_status' => fake()->randomElement(['open', 'close', 'private']),
        ];
    }
}
