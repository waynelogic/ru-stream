<?php

namespace App\Services;

use danog\MadelineProto\API;
use danog\MadelineProto\Settings\AppInfo;
use Storage;
class Telegram
{
    public static function make($phone) : API
    {
        if (is_null($phone)) {
            $phone = session()->get('current_telegram_phone');
        }
        $settings = (new AppInfo)
            ->setApiId(config('madeline-proto.api_id'))
            ->setApiHash(config('madeline-proto.api_hash'));

        return new API(Storage::path('madeline-proto/' . $phone), $settings);
    }
}
