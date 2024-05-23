<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $newsArticles = NewsArticle::with('newsArticleCategory')
            ->orderByDesc('published_at');


        $tag = request('tag');
        if ($tag) {
            if ($tag === 'all') {
                Session::remove('tag');
            } else {
                Session::put('tag', $tag);
            }
        }

        if (Session::get('tag')) {
            $sessionTag = Session::get('tag');
            $newsArticles->where('category_id', $sessionTag);
        }


        $newsArticles = $newsArticles->paginate(5);

        return view('news.index')->with([
            'newsArticles' => $newsArticles,
            'tag' => $sessionTag ?? null,
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
        $newsArticle = NewsArticle::with('newsArticleCategory')
            ->find($id);

        return view('news.show')->with([
            'newsArticle' => $newsArticle,
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
