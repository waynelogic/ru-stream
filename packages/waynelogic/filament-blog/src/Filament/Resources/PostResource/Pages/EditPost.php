<?php

namespace Waynelogic\FilamentBlog\Filament\Resources\PostResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Waynelogic\FilamentBlog\Filament\Resources\PostResource;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('preview')
                ->label('Предпросмотр')
                ->url($this->record->url, true),
            Actions\DeleteAction::make(),
        ];
    }
}
