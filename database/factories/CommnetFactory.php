<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CommnetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            $currentDate = fake()->dateTime(),
            'post_id' => fake()->id,
            'author' => fake()->userName,
            'text' => fake()->text(200),
            'created_at' => $currentDate,
            'updated_at' => $currentDate,

        ];
    }
}
