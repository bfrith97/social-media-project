<?php

namespace App\Services;

use App\Constants\NewsCategory;
use App\Models\NewsArticle;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class NewsService
{
    private string $apiKey;
    private string $url;

    public function __construct()
    {
        $this->apiKey = '0eae552ae39f4f3a876ab916098aa3b5';
        $this->url = 'https://newsapi.org/v2/top-headlines';
    }

    public function getNewsHeadlines()
    {
        return Cache::remember('news_headlines', now()->addHours(1), function () {
            $healthHeadlines = $this->headlinesRequest('health', NewsCategory::HEALTH);
            $businessHeadlines = $this->headlinesRequest('business', NewsCategory::BUSINESS);
            $scienceHeadlines = $this->headlinesRequest('science', NewsCategory::SCIENCE);
            $sportsHeadlines = $this->headlinesRequest('sports', NewsCategory::HEALTH);
            $technologyHeadlines = $this->headlinesRequest('technology', NewsCategory::TECHNOLOGY);

            $mergedHeadlines = array_merge($healthHeadlines, $businessHeadlines, $scienceHeadlines, $sportsHeadlines, $technologyHeadlines);

            $this->writeHeadlinesToDatabase($mergedHeadlines);

            return NewsArticle::orderByDesc('published_at')->get()->take(5);
        });
    }

    private function headlinesRequest($category, $categoryId): ?array
    {
        $response = Http::get($this->url, [
            'country' => 'gb',
            'category' => 'health',
            'apiKey' => $this->apiKey,
        ]);

        if ($response->successful()) {
            $articles = $response->json()['articles'];
            $slicedArray = array_slice($articles, 0, 5);

            foreach ($slicedArray as $key => &$article) {
                $this->setCategoryAndRemoveKeys($article, $categoryId);
                if ($article === null) {
                    unset($slicedArray[$key]);
                }
            }

            return $slicedArray;
        } else {
            return null;
        }
    }

    private function setCategoryAndRemoveKeys(&$article, $categoryId): void
    {
        $article['category_id'] = $categoryId;
        $article['published_at'] = $article['publishedAt'];
        unset($article['publishedAt']);
        unset($article['content']);
        unset($article['source']);
        unset($article['urlToImage']);

        if ($article['title'] === '[Removed]') {
            $article = null; // Set the entire article to null
        }
    }

    private function writeHeadlinesToDatabase($mergedHeadlines): ?bool
    {
        // Retrieve all unique titles from the array of headlines to be inserted
        $titles = array_column($mergedHeadlines, 'title');

        // Fetch titles from the database that are in the titles array
        $existingTitles = NewsArticle::whereIn('title', $titles)
            ->pluck('title')
            ->toArray();

        // Filter out headlines that have titles already existing in the database
        $filteredHeadlines = array_filter($mergedHeadlines, function ($headline) use ($existingTitles) {
            return !in_array($headline['title'], $existingTitles);
        });

        // Insert new headlines that do not have duplicate titles
        if (!empty($filteredHeadlines)) {
            $newsArticles = NewsArticle::insert($filteredHeadlines);
            return $newsArticles;
        }

        return null; // Return null or a suitable response if no new headlines are inserted
    }

}
