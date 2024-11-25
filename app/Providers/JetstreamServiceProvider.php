<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Laravel\Fortify\Fortify;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::registerView(function () {
            return Inertia::render('Auth/Register', [
                'partner' => User::where('login', Cookie::get('referer'))->first(),
            ]);
        });
//        Jetstream::inertia()->whenRendering('Auth/Register', fn($request, $data) =>
//            array_merge($data, [
//                'partner' => User::where('login', Cookie::get('referer'))->first(),
//            ])
//        );


        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);

        Vite::prefetch(concurrency: 3);
    }

    /**
     * Configure the permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
