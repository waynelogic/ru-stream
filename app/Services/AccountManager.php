<?php namespace App\Services;

use App\Enums\StreamType;
use App\Models\User;
use Exception;

class AccountManager
{
    public static function accounts(StreamType $type , ?User $user = null)
    {
        $user = $user ?? auth()->user();
        return match ($type) {
            StreamType::VKPage, StreamType::VKStories => $user->vk_user(),
            StreamType::VKGroup => $user->vk_groups(),
            StreamType::TgChannel => $user->tg_channels(),
        };
    }

    /**
     * @throws Exception
     */
    public static function account(StreamType $type, int $account_id, ?User $user = null)
    {
        $user = $user ?? auth()->user();

        return self::accounts($type, $user)->where('id', $account_id)->first();
    }
}
