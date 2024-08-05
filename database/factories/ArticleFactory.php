<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(5);
        return [
            'title' => $title,
            'body' => [
            'short' => fake()->paragraph,
            'long' => fake()->text(500),
            ],
            'user_id' => User::factory(),
            'special_words' => fake()->words(2, true),
            'views' => fake()->randomNumber(3, true),
            'slug' => Str::slug($title) . '-' . fake()->numberBetween(1, 10000),
            'status' => fake()->numberBetween(0, 1),
        ];
    }
}
