<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Services\StreamManagementService;
use App\Services\SubscriptionManager;
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


\Illuminate\Support\Facades\Schedule::call(function () {
    \Illuminate\Support\Facades\Log::info('Cron is working');
    $obStreamManager = (new StreamManagementService());
    $obStreamManager->stopExpiredStreams();
    $obStreamManager->startNewStreams();
    $obStreamManager->startRecicledStreams();

    $obSubManager = (new SubscriptionManager());
    $obSubManager->notifyAllEnding();
    $obSubManager->renewAllEnding();
})->everyMinute();
