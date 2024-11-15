<?php namespace Waynelogic\FilamentCms\Filament\Resources;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettingsResource extends Resource
{
    protected static ?string $pluralLabel = 'Настройки';

    protected static ?string $label = 'Настройки';

    protected static ?string $navigationLabel = 'Настройки';
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $activeNavigationIcon = 'heroicon-s-cog-6-tooth';

    protected static ?string $navigationGroup = 'Система';
    protected static ?int $navigationSort = 800;

    public static function form(Form $form): Form
    {
        return $form->schema([
                //
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => SettingsResource\Pages\ListSettings::route('/'),
//            'list' => SettingsResource\Pages\ListSettingsOld::route('/list'),
            'create' => SettingsResource\Pages\CreateSettings::route('/create'),
            'edit' => SettingsResource\Pages\EditSettings::route('/{record}'),
        ];
    }
}
