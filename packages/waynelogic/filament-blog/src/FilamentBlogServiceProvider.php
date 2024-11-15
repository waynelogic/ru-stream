<?php namespace Waynelogic\FilamentBlog;

use Illuminate\Support\ServiceProvider;

class FilamentBlogServiceProvider extends ServiceProvider
{
    //    php artisan vendor:publish --provider="Waynelogic\FilamentBlog\FilamentBlogServiceProvider" --tag="migrations"
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
//        $this->publishesMigrations([
//            __DIR__.'/../database/migrations' => database_path('migrations'),
//        ]);
    }
}
