<?php

namespace App\Services;

use App\Models\Stream;

class StreamManagementService
{
    public static function instance()
    {
        return app(StreamManagementService::class);
    }

    public function stopExpiredStreams(): void
    {
        $arStreams = Stream::where('is_online', true)->where('expires_at', '<=', now())->get();

        foreach ($arStreams as $obStream) {
            $obStream->stop();
        }
    }

    public function startNewStreams()
    {
        $arStreams = Stream::where('play_count', 0)
            ->where('start_at', '<=', now())
            ->get();

        foreach ($arStreams as $obStream) {
            $obStream->play();
        }
    }

    public function startRecicledStreams()
    {
        $arStreams = Stream::where('is_online', false)
            ->where('next_at', '<=', now())
            ->get();

        foreach ($arStreams as $obStream) {
            $obStream->play();
        }
    }
}
