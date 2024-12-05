<?php namespace App\Enums;

use Carbon\Carbon;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum SubscriptionFrequency: string implements HasColor, HasLabel
{
    case MONTHLY = 'monthly';
    case ANNUALLY = 'annually';

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::MONTHLY => 'info',
            self::ANNUALLY => 'danger',
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::MONTHLY => 'месяц',
            self::ANNUALLY => 'год',
        };
    }

    public function getPriceColumn() : ?string
    {
        return match ($this) {
            self::MONTHLY => 'monthly_price',
            self::ANNUALLY => 'yearly_price',
        };
    }

    public function getEndDate(Carbon $start_at) : Carbon
    {
        return match ($this) {
            self::MONTHLY => $start_at->copy()->addMonth(),
            self::ANNUALLY => $start_at->copy()->addYear(),
        };
    }
}
