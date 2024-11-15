<?php namespace Waynelogic\FilamentBlog;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Waynelogic\FilamentBlog\Filament\Resources;

class FilamentBlogPlugin implements Plugin
{
    public function getId(): string
    {
        return 'blog';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                Resources\PostResource::class,
//                Resources\CategoryResource::class,
            ])
            ->pages([
//                Settings::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
