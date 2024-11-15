<?php namespace Waynelogic\FilamentCms;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Waynelogic\FilamentCms\Models\BackendUser;

class FilamentCmsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'filament-cms');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->registerBlueprints();

        $authConfig = Config::get('auth');
        $authConfig['providers'] = array_merge($authConfig['providers'], [
            'admins' => [
                'driver' => 'eloquent',
                'model' => BackendUser::class,
            ],
        ]);
        $authConfig['guards'] = array_merge($authConfig['guards'], [
            'admin' => [
                'driver' => 'session',
                'provider' => 'admins',
            ],
        ]);
        Config::set('auth', $authConfig);
    }

    private function registerBlueprints(): void
    {
        Blueprint::macro('slug' , function ($columnName = 'slug', $nullable = false) {
            return $this->string($columnName)->unique()->nullable($nullable);
        });

        Blueprint::macro('sortable', function ($columnName = 'sort_order', $default = 0) {
            return $this->integer($columnName)->default($default);
        });

        Blueprint::macro('defaultable', function ($columnName = 'is_default', $default = false) {
            return $this->boolean($columnName)->default($default);
        });
    }
}
