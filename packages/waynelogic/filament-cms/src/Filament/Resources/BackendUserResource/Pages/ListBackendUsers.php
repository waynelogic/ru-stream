<?php

namespace Waynelogic\FilamentCms\Filament\Resources\BackendUserResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Waynelogic\FilamentCms\Filament\Resources\BackendUserResource;

class ListBackendUsers extends ListRecords
{
    protected static string $resource = BackendUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
