<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use PharIo\Manifest\Author;

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
            'author_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'title' => $this->faker->text(20),
            'slug' => $this->faker->slug(),
            'content' => $this->faker->paragraph(),
            'image' => $this->faker->imageUrl(),
            'status'=> $this->faker->randomElement(['draft', 'published', 'archived']),
            'category' => $this->faker->word(),
        ];
    }
}
