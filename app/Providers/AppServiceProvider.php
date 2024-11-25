<?php namespace App\Providers;

use App\Http\Resources;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

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
        Resources\VkUserResource::withoutWrapping();
        Resources\SubscriptionResource::withoutWrapping();
        Resources\VideoResource::withoutWrapping();

        RedirectResponse::macro('flashMessage', function ($type, $message) {
            return $this->with('flashy', ['type' => $type, 'message' => $message]);
        });
        RedirectResponse::macro('flash', fn ($message) => $this->flashMessage('info', $message));
        RedirectResponse::macro('flashSuccess', fn ($message) => $this->flashMessage('success', $message));
        RedirectResponse::macro('flashWarning', fn ($message) => $this->flashMessage('warning', $message));
        RedirectResponse::macro('flashError', fn ($message) => $this->flashMessage('error', $message));
    }
}
