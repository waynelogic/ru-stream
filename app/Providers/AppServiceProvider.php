<?php

namespace App\Providers;

use App\Http\Resources\VkUserResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * @method static RedirectResponse flashSuccess(string $message)
     */
    public function boot(): void
    {
        VkUserResource::withoutWrapping();

        RedirectResponse::macro('flashMessage', function ($type, $message) {
            return $this->with('flashy', ['type' => $type, 'message' => $message]);
        });
        RedirectResponse::macro('flash', fn ($message) => $this->flashMessage('info', $message));
        RedirectResponse::macro('flashSuccess', fn ($message) => $this->flashMessage('success', $message));
        RedirectResponse::macro('flashWarning', fn ($message) => $this->flashMessage('warning', $message));
        RedirectResponse::macro('flashError', fn ($message) => $this->flashMessage('error', $message));
    }
}
