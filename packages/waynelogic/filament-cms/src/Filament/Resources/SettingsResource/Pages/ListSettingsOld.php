<?php

namespace Waynelogic\FilamentCms\Filament\Resources\SettingsResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Waynelogic\FilamentCms\Filament\Resources\SettingsResource;

class ListSettingsOld extends ListRecords
{
    protected static string $resource = SettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
