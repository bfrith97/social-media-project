<?php

namespace Tests\Integration\News;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Tests\Traits\ModelFactoryTrait;

class NewsTest extends TestCase
{
    use WithFaker, DatabaseTransactions, ModelFactoryTrait;

    public function setUp(): void
    {
        parent::setUp();

        $this->apiKey = config('services.news.api_key');
        $this->url = config('services.news.api_url');
    }

    //Tests
    public function test_api_connection(): void
    {
        $response = Http::get($this->url, [
            'country' => 'gb',
            'category' => 'science',
            'apiKey' => $this->apiKey,
        ]);

        $this->assertEquals(200, $response->status());
    }
}
