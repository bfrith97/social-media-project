<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('posts.index');
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('/news', NewsController::class);

    Route::resource('/events', EventController::class);

    Route::get('/feed', [PostController::class, 'index'])->name('posts.index');

    Route::resource('/groups', GroupController::class);

    Route::resource('/messages', MessageController::class);

    Route::resource('/profiles', ProfileController::class);

    Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings/account', [SettingController::class, 'accountUpdate'])->name('settings.account_update');

    Route::get('/profiles', [ProfileController::class, 'edit'])->name('profiles.edit');
    Route::patch('/profiles', [ProfileController::class, 'update'])->name('profiles.update');
    Route::delete('/profiles', [ProfileController::class, 'destroy'])->name('profiles.destroy');
});

require __DIR__ . '/auth.php';
