<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use \App\Services\StreamManagementService;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


\Illuminate\Support\Facades\Schedule::call(function () {
    \Illuminate\Support\Facades\Log::info('Cron is working');
    StreamManagementService::instance()->stopExpiredStreams();
    StreamManagementService::instance()->startNewStreams();
    StreamManagementService::instance()->startRecicledStreams();
})->everyMinute();
