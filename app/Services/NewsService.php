<?php

namespace App\Services;

use App\Models\NewsArticle;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravolt\Avatar\Avatar;

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
            $healthHeadlines = $this->getHealthHeadlines();
            $businessHeadlines = $this->getBusinessHeadlines();
            $scienceHeadlines = $this->getScienceHeadlines();
            $sportsHeadlines = $this->getSportsHeadlines();
            $technologyHeadlines = $this->getTechnologyHeadlines();

            $mergedHeadlines = array_merge($healthHeadlines, $businessHeadlines, $scienceHeadlines, $sportsHeadlines, $technologyHeadlines);

            $this->writeHeadlinesToDatabase($mergedHeadlines);

            return NewsArticle::orderBy('published_at')->get()->take(5);
        });
    }

    private function getHealthHeadlines(): ?array
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
                $this->setCategoryAndRemoveKeys($article, 1);
                if ($article === null) {
                    unset($slicedArray[$key]); // Remove the article from the array if it's set to null
                }
            }

            return $slicedArray;
        } else {
            return null;
        }
    }

    private function getBusinessHeadlines(): ?array
    {
        $response = Http::get($this->url, [
            'country' => 'gb',
            'category' => 'business',
            'apiKey' => $this->apiKey,
        ]);

        if ($response->successful()) {
            $articles = $response->json()['articles'];
            $slicedArray = array_slice($articles, 0, 5);

            foreach ($slicedArray as $key => &$article) {
                $this->setCategoryAndRemoveKeys($article, 2);
                if ($article === null) {
                    unset($slicedArray[$key]); // Remove the article from the array if it's set to null
                }
            }

            return $slicedArray;
        } else {
            return null;
        }
    }

    private function getScienceHeadlines(): ?array
    {
        $response = Http::get($this->url, [
            'country' => 'gb',
            'category' => 'science',
            'apiKey' => $this->apiKey,
        ]);

        if ($response->successful()) {
            $articles = $response->json()['articles'];
            $slicedArray = array_slice($articles, 0, 5);

            foreach ($slicedArray as $key => &$article) {
                $this->setCategoryAndRemoveKeys($article, 3);
                if ($article === null) {
                    unset($slicedArray[$key]); // Remove the article from the array if it's set to null
                }
            }

            return $slicedArray;
        } else {
            return null;
        }
    }

    private function getSportsHeadlines(): ?array
    {
        $response = Http::get($this->url, [
            'country' => 'gb',
            'category' => 'sports',
            'apiKey' => $this->apiKey,
        ]);

        if ($response->successful()) {
            $articles = $response->json()['articles'];
            $slicedArray = array_slice($articles, 0, 5);

            foreach ($slicedArray as $key => &$article) {
                $this->setCategoryAndRemoveKeys($article, 4);
                if ($article === null) {
                    unset($slicedArray[$key]); // Remove the article from the array if it's set to null
                }
            }

            return $slicedArray;
        } else {
            return null;
        }
    }

    private function getTechnologyHeadlines(): ?array
    {
        $response = Http::get($this->url, [
            'country' => 'gb',
            'category' => 'technology',
            'apiKey' => $this->apiKey,
        ]);

        if ($response->successful()) {
            $articles = $response->json()['articles'];
            $slicedArray = array_slice($articles, 0, 5);

            foreach ($slicedArray as $key => &$article) {
                $this->setCategoryAndRemoveKeys($article, 5);
                if ($article === null) {
                    unset($slicedArray[$key]); // Remove the article from the array if it's set to null
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
