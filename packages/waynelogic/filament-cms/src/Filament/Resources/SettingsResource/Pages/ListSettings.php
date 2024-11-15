<?php namespace Waynelogic\FilamentCms\Filament\Resources\SettingsResource\Pages;

use Filament\Resources\Pages\Page;
use Waynelogic\FilamentCms\Cms\SettingsManager;
use Waynelogic\FilamentCms\Filament\Resources\SettingsResource;

class ListSettings extends Page
{
    protected static string $resource = SettingsResource::class;

    protected static ?string $title = 'Настройки';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament-cms::filament.pages.settings';

    public function mount(): void
    {
        $this->arGroups = SettingsManager::instance()->listItems('system');
    }

    protected ?string $maxContentWidth = 'full';
}
