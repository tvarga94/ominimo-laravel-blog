<?php

namespace App\Providers;

use App\CommentRepositoryInterface;
use App\Http\Repositories\CommentRepository;
use App\Http\Repositories\PostRepository;
use App\PostRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
