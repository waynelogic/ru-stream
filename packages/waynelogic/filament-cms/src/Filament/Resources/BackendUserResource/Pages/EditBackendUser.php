<?php

namespace Waynelogic\FilamentCms\Filament\Resources\BackendUserResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Waynelogic\FilamentCms\Filament\Resources\BackendUserResource;

class EditBackendUser extends EditRecord
{
    protected static string $resource = BackendUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
