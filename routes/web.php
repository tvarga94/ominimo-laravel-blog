<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Middleware\RedirectAfterLogin;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('posts.index');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware(RedirectAfterLogin::class);

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('posts.index');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class)->except(['index', 'show']);
    Route::post('/posts/{id}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

Route::resource('posts', PostController::class)->only(['show']);

require __DIR__.'/auth.php';
