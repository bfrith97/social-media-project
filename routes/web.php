<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentLikeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\FollowController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RetrieveNotifications;

Route::get('/', function () {
    return redirect()->route('posts.index');
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

    Route::post('/comment-likes', [CommentLikeController::class, 'store'])->name('comment_likes.store');
    Route::delete('/comment-likes', [CommentLikeController::class, 'destroy'])->name('comment_likes.destroy');

    Route::resource('/events', EventController::class);

    Route::get('/feed', [PostController::class, 'index'])->name('posts.index');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    Route::resource('/groups', GroupController::class);

    Route::post('/post-likes', [PostLikeController::class, 'store'])->name('post_likes.store');
    Route::delete('/post-likes', [PostLikeController::class, 'destroy'])->name('post_likes.destroy');

    Route::resource('/messages', MessageController::class);

    Route::resource('/news', NewsController::class);

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark_all_read');

    Route::resource('/profiles', ProfileController::class);
    Route::get('/profiles', [ProfileController::class, 'edit'])->name('profiles.edit');
    Route::patch('/profiles', [ProfileController::class, 'update'])->name('profiles.update');
    Route::delete('/profiles', [ProfileController::class, 'destroy'])->name('profiles.destroy');

    Route::get('/search', [SearchController::class, 'search'])->name('search');

    Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings/account', [SettingController::class, 'accountUpdate'])->name('settings.account_update');

    Route::get('/who-to-follow', [FollowController::class, 'index'])->name('who_to_follow.index');
    Route::post('/follows', [FollowController::class, 'store'])->name('follows.store');
    Route::delete('/follows', [FollowController::class, 'destroy'])->name('follows.destroy');
})->middleware('auth:web');

require __DIR__ . '/auth.php';
