<?php

namespace Waynelogic\FilamentCms\Models;

use Filament\Forms\Components\TextInput;

class MailSetting extends SettingModel
{
    /**
     * @var string settingsCode is a unique code for these settings
     */
    public $settingsCode = 'system_mail_settings';

    public string $label = 'Настройки почты';

    public static function getFormSchema() : array
    {
        return [
            TextInput::make('mail_send_server')->label('SMTP Server')->default('smtp.gmail.com'),
            TextInput::make('mail_send_port')->numeric()->default(587),
        ];
    }
}
