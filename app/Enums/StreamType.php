<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum StreamType: string implements HasColor, HasLabel
{
    case VKPage = 'vk-page';
    case VKStories = 'vk-stories';
    case VKGroup = 'vk-group';
    case Telegram = 'telegram';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::VKPage => 'Страница ВКонтакте',
            self::VKStories => 'Истории ВКонтакте',
            self::VKGroup => 'Группа ВКонтакте',
            self::Telegram => 'Telegram',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::VKPage => 'info',
            self::VKStories => 'warning',
            self::VKGroup => 'success',
            self::Telegram => 'info',
        };
    }


    public function attachmentColumn(): ?string
    {
        return match ($this) {
            self::VKPage => 'is_in_page',
            self::VKStories => 'is_in_stories',
            self::VKGroup => 'in_dashboard',
            default => null
        };
    }

    public function isStory()
    {
        return in_array($this, [self::VKStories]);
    }
}
