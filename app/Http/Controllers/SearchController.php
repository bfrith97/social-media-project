<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use App\Services\ProfileService;
use App\Services\SearchService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends BaseController
{
    private SearchService $searchService;

    public function __construct(SearchService $searchService) {
        $this->searchService = $searchService;
    }

    public function search(Request $request)
    {
        return $this->searchService->getSearchResults($request);
    }
}
