<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum AutoRepeatInterval : int implements HasLabel
{
    case HALF_HOUR = 30;
    case HOUR = 60;
    case TWO_HOURS = 120;
    case FOUR_HOURS = 240;
    case SIX_HOURS = 360;
    case EIGHT_HOURS = 480;
    case TWELVE_HOURS = 720;
    case DAY = 1440;

    public static function getAll()
    {
        $arItems = [];
        foreach (self::cases() as $item) {
            $arItems[] = [
                'label' => $item->getLabel(),
                'handle' => $item->name,
                'value' => $item->value,
            ];
        }
        return $arItems;
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::HALF_HOUR => '30 минут',
            self::HOUR => '1 час',
            self::TWO_HOURS => '2 часа',
            self::FOUR_HOURS => '4 часа',
            self::SIX_HOURS => '6 часов',
            self::EIGHT_HOURS => '8 часов',
            self::TWELVE_HOURS => '12 часов',
            self::DAY => '1 день',
        };
    }
}
