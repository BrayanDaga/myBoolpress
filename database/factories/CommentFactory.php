<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $currentDate = fake()->dateTime();
        return [
            // 'post_id' = $post->id,
            'author' => fake()->userName,
            'text' => fake()->text(200),
            'created_at' => $currentDate,
            'updated_at' => $currentDate
        ];
    }
}
