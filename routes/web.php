<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('posts.index');
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

    Route::resource('/events', EventController::class);

    Route::get('/feed', [PostController::class, 'index'])->name('posts.index');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    Route::resource('/groups', GroupController::class);

    Route::post('/post_likes', [PostLikeController::class, 'store'])->name('post_likes.store');
    Route::delete('/post_likes', [PostLikeController::class, 'destroy'])->name('post_likes.destroy');

    Route::resource('/messages', MessageController::class);

    Route::resource('/news', NewsController::class);

    Route::resource('/profiles', ProfileController::class);
    Route::get('/profiles', [ProfileController::class, 'edit'])->name('profiles.edit');
    Route::patch('/profiles', [ProfileController::class, 'update'])->name('profiles.update');
    Route::delete('/profiles', [ProfileController::class, 'destroy'])->name('profiles.destroy');

    Route::get('/search', [SearchController::class, 'search'])->name('search');

    Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');

    Route::put('/settings/account', [SettingController::class, 'accountUpdate'])->name('settings.account_update');
});

require __DIR__ . '/auth.php';
