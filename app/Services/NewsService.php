<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravolt\Avatar\Avatar;

class NewsService
{
    public function getNewsHeadlines(): ?array
    {
        return Cache::remember('news_headlines', now()->addHours(1), function () {
            $apiKey = '0eae552ae39f4f3a876ab916098aa3b5';
            $url = 'https://newsapi.org/v2/top-headlines';

            $response = Http::get($url, [
                'country' => 'gb',
                'apiKey' => $apiKey,
            ]);

            if ($response->successful()) {
                return $news = array_slice($response->json()['articles'], 0, 5);
            } else {
                return null;
            }
        });
    }
}
