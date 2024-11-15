<?php

use App\Http\Controllers;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('videos', Controllers\VideoController::class);
    Route::resource('stories', Controllers\StoryController::class);

    Route::group(['prefix' => 'subscriptions', 'as' => 'subscriptions.',], function () {
        Route::post('/', [Controllers\SubscriptionController::class, 'store'])->name('store');
    });

    /** Stream */
    Route::group(['prefix' => 'streams', 'as' => 'streams.'], function () {
        Route::get('/', function () {return request()->route('dashboard');});
        Route::get('/{type}', [Controllers\StreamController::class, 'index'])->name('index');
        Route::get('/{type}/create/{account_id}', [Controllers\StreamController::class, 'create'])->name('create');
        Route::post('/attachAccount/{type}', [Controllers\StreamController::class, 'attachAccount'])->name('attachAccount');
        Route::post('/detachAccount/{type}', [Controllers\StreamController::class, 'detachAccount'])->name('detachAccount');
    });

    /** Auth */
    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
        /* Telegram */
        Route::any('/telegram/{method}', [Controllers\Auth\TelegramAuthController::class, 'index'])->name('telegram');
        /* VK */
        Route::group([
            'prefix' => 'vk',
            'as' => 'vk.',
        ], function () {
            Route::get('redirect', [Controllers\Auth\VkPageAuthController::class, 'redirect'])->name('redirect');
            Route::get('callback', [Controllers\Auth\VkPageAuthController::class, 'callback'])->name('callback');
        });
    });
});

Route::get('/plans', [Controllers\PricingPlanController::class, 'index'])->name('plans.index');

Route::get('/test', [Controllers\TestController::class, 'index']);
