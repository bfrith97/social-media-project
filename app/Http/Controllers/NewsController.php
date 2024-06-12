<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;
use App\Services\NewsService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class NewsController extends Controller
{
    private NewsService $newsService;
    private UserService $userService;

    public function __construct(NewsService $newsService, UserService $userService)
    {
        $this->newsService = $newsService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        [$user, $conversations, $notificationsCount] = $this->userService->getUserInformation();
        [$newsArticles, $sessionTag] = $this->newsService->getNewsArticles($request);

        return view('news.index')->with([
            'newsArticles' => $newsArticles,
            'tag' => $sessionTag,
            'notificationsCount' => $notificationsCount,
            'user' => $user,
            'conversations' => $conversations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        [$user, $conversations, $notificationsCount] = $this->userService->getUserInformation();

        $newsArticle = $this->newsService->getNewsArticle($id);

        return view('news.show')->with([
            'newsArticle' => $newsArticle,
            'notificationsCount' => $notificationsCount,
            'user' => $user,
            'conversations' => $conversations,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
