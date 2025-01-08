<?php

namespace App\Services;

use danog\MadelineProto\API;
use danog\MadelineProto\Exception;
use danog\MadelineProto\Settings;
use danog\MadelineProto\Settings\AppInfo;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Storage;
class Telegram
{
    public static function path(int $phone, string $path = null): ?string
    {
        $fullPath = Storage::path('madeline-proto/' . $phone);
        if (!is_null($path)) {
            return $fullPath . '/' . $path;
        }
        return $fullPath;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws Exception
     * @throws NotFoundExceptionInterface
     */
    public static function make($phone) : API
    {
        if (is_null($phone)) {
            $phone = session()->get('current_telegram_phone');
        }

        $appInfo = (new AppInfo)
            ->setApiId(config('madeline-proto.api_id'))
            ->setApiHash(config('madeline-proto.api_hash'));

        $settings = (new Settings())
            ->setAppInfo($appInfo);

        return new API(self::path($phone), $settings);
    }
}
