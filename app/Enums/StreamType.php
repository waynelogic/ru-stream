<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum StreamType: string implements HasColor, HasLabel
{
    case VKPage = 'vk-page';
    case VKStories = 'vk-stories';
    case VKGroup = 'vk-group';
    case TgChannel = 'tg-channel';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::VKPage => 'Страница ВКонтакте',
            self::VKStories => 'Истории ВКонтакте',
            self::VKGroup => 'Группа ВКонтакте',
            self::TgChannel => 'Канал Telegram',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::VKPage => 'info',
            self::VKStories => 'warning',
            self::VKGroup => 'success',
            self::TgChannel => 'info',
        };
    }


    public function attachmentColumn(): ?string
    {
        return match ($this) {
            self::VKPage => 'is_in_page',
            self::VKStories => 'is_in_stories',
            self::VKGroup => 'in_dashboard',
            self::TgChannel => 'is_in_channel',
            default => null
        };
    }

    public function isStory()
    {
        return in_array($this, [self::VKStories]);
    }
}
