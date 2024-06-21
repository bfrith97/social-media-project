<?php

namespace Database\Factories;

use App\Models\NewsArticle;
use App\Models\NewsArticleCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class NewsArticleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'author' => $this->faker->word(),
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'url' => $this->faker->url(),
            'published_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'category_id' => NewsArticleCategory::inRandomOrder()->first()->id
        ];
    }
}
