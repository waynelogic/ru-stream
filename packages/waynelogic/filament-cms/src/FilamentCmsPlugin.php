<?php namespace Waynelogic\FilamentCms;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\Support\Facades\Event;
use Waynelogic\FilamentCms\Cms\SettingsMenuItem;
use Waynelogic\FilamentCms\Filament\Resources\BackendUserResource;
use Waynelogic\FilamentCms\Filament\Resources\SettingsResource;
use Waynelogic\FilamentCms\Models\MailSetting;

class FilamentCmsPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-cms';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            BackendUserResource::class,
            SettingsResource::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        Event::listen('cms.register.navigation', function() {
            return [
                SettingsMenuItem::make('mail_settings')
                    ->label('Настройки почты')
                    ->description('Настройки почты в системе')
                    ->category('Системные настройки')
                    ->class(MailSetting::class)
                    ->order(200)
                    ->icon('heroicon-o-at-symbol'),

                SettingsMenuItem::make('backend_users')
                    ->label( 'Администраторы')
                    ->description('Настройка рользователи системы')
                    ->category('Системные настройки')
                    ->url(BackendUserResource::getUrl('index'))
                    ->order(300)
                    ->icon('heroicon-o-user-group'),
            ];
        });
    }
}
