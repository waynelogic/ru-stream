<?php

namespace Waynelogic\FilamentCms\Filament\Resources\SettingsResource\Pages;

use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Exceptions\Halt;
use Filament\Support\Facades\FilamentView;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Waynelogic\FilamentCms\Cms\SettingsManager;
use Waynelogic\FilamentCms\Filament\Resources\SettingsResource;
use Waynelogic\FilamentCms\Models\MailSetting;
use function Filament\Support\is_app_url;

class EditSettings extends EditRecord
{
    protected static string $resource = SettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }


    public function form(Form $form): Form
    {
        return $form->schema($this->record::getFormSchema());
    }
    protected function resolveRecord(int | string $key): Model
    {
        $this->setting = SettingsManager::instance()->findSettingItem($key);

        if ($this->setting === null) {
            abort(404);
        }
        $class = $this->setting->class;
        $record = $class::instance();

        if ($record === null) {
            throw (new ModelNotFoundException())->setModel($this->getModel(), [$key]);
        }

        return $record;
    }

    public function getTitle(): string|\Illuminate\Contracts\Support\Htmlable
    {
        return $this->record->label;
    }


    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->forceFill($data);
        $record->save();

        return $record;
    }
}
