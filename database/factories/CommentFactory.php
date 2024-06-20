<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
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
        return [
            'content' => fake()->text(100),
            'user_id' => User::inRandomOrder()->first()->id,
            'item_id' => Post::inRandomOrder()->first()->id,
            'item_type' => Post::class,
        ];
    }
}
