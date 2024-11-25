<?php

use App\Http\Controllers;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', [Controllers\HomeController::class, 'index'])->name('home');
Route::get('plans', [Controllers\PricingPlanController::class, 'index'])->name('plans.index');
Route::get('cases', [Controllers\CaseController::class, 'index'])->name('cases');

Route::group(['prefix' => 'blog', 'as' => 'blog.',], function () {
    Route::get('/', [Controllers\BlogController::class, 'index'])->name('index');
    Route::get('/{slug}', [Controllers\BlogController::class, 'show'])->name('show');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/instructions', [Controllers\InstructionController::class, 'index'])->name('instructions.index');

    /** Dashboard */
    Route::get('/dashboard', [Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/makePayment', [Controllers\DashboardController::class, 'payment'])->name('dashboard.payment');
    Route::post('/usePromoCode', [Controllers\DashboardController::class, 'usePromoCode'])->name('dashboard.usePromoCode');

    Route::resource('videos', Controllers\VideoController::class);
    Route::resource('stories', Controllers\StoryController::class);

    Route::group(['prefix' => 'subscriptions', 'as' => 'subscriptions.',], function () {
        Route::post('/', [Controllers\SubscriptionController::class, 'store'])->name('store');
        Route::patch('/{subscription}', [Controllers\SubscriptionController::class, 'update'])->name('update');
    });

    /** Stream */
    Route::group(['prefix' => 'streams', 'as' => 'streams.'], function () {
        Route::get('/', function () {return request()->route('dashboard');});
        Route::get('/{type}', [Controllers\StreamController::class, 'index'])->name('index');
        Route::get('/{type}/create/{account_id}', [Controllers\StreamController::class, 'create'])->name('create');
        Route::post('/{type}/store', [Controllers\StreamController::class, 'store'])->name('store');
        Route::post('/attachAccount/{type}', [Controllers\StreamController::class, 'attachAccount'])->name('attachAccount');
        Route::post('/detachAccount/{type}', [Controllers\StreamController::class, 'detachAccount'])->name('detachAccount');

        Route::post('/play/{id}', [Controllers\StreamController::class, 'play'])->name('play');
        Route::post('/stop/{id}', [Controllers\StreamController::class, 'stop'])->name('stop');
        Route::delete('/{id}', [Controllers\StreamController::class, 'destroy'])->name('destroy');
    });

    /** Auth */
    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
        /* Telegram */
        Route::any('/telegram/{method}', [Controllers\Auth\TelegramAuthController::class, 'index'])->name('telegram');
        /* VK */
        Route::group(['prefix' => 'vk', 'as' => 'vk.',], function () {
            Route::get('redirect{type?}', [Controllers\Auth\VkPageAuthController::class, 'redirect'])->name('redirect');
            Route::get('callback', [Controllers\Auth\VkPageAuthController::class, 'callback'])->name('callback');
        });
    });
});



Route::get('/test', [Controllers\TestController::class, 'index']);

Route::get('/sse', function () {
    return response()->stream(function () {
        echo "data: " . json_encode(['progress' => session()->get('progress')]) . "\n\n";
    }, 200, [
        'Content-Type' => 'text/event-stream',
        'Cache-Control' => 'no-cache',
        'Connection' => 'keep-alive',
    ]);
});

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
