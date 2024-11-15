<?php

namespace Waynelogic\FilamentCms\Cms;

use Waynelogic\FilamentCms\Filament\Resources\SettingsResource\Pages\EditSettings;

class SettingsMenuItem
{

    public string $code;

    public string $label;

    public ?string $description = null;

    public string $category = 'Разное';

    public int $order = 600;

    public ?string $icon = null;
    public ?string $class = null;
    public ?string $url = null;

    public function __construct(string $code, string $label)
    {
        $this->code = $code;
        $this->label = $label;
    }
    public static function make(string $code): static
    {
        return app(static::class, ['code' => $code, 'label' => $code]);
    }

    public function label(string $label): static
    {
        $this->label = $label;
        return $this;
    }

    public function description(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function category(string $category): static
    {
        $this->category = $category;
        return $this;
    }

    public function icon(string $icon): static
    {
        $this->icon = $icon;
        return $this;
    }

    public function class(string $class): static
    {
        $this->class = $class;

        $this->url = EditSettings::getUrl(['record' => $this->code]);
        return $this;
    }

    public function url(string $url): static
    {
        $this->url = $url;
        return $this;
    }

    public function order(int $order): static
    {
        $this->order = $order;
        return $this;
    }
}
