<?php namespace Waynelogic\FilamentCms\Filament\Resources;

use Waynelogic\FilamentCms\Filament\Resources\BackendUserResource\RelationManagers;
use Waynelogic\FilamentCms\Models\BackendUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BackendUserResource extends Resource
{
    protected static ?string $model = BackendUser::class;

    protected static ?string $label = 'Администратор';
    protected static ?string $pluralLabel = 'Администраторы';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $activeNavigationIcon = 'heroicon-s-user-group';

    protected static bool $shouldRegisterNavigation = false;


    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Пользователь')->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Имя')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(),

            ])->columns(2),
                Forms\Components\Section::make('Пароль')->schema([
                    Forms\Components\Toggle::make('change_password')
                        ->inlineLabel()
                        ->live()
                        ->label('Сменить пароль?'),
                    Forms\Components\TextInput::make('password')
                        ->label('Пароль')
                        ->inlineLabel()
                        ->live()
                        ->disabled(fn(Forms\Get $get) => ! $get('change_password')),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Имя')
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->sortable(),
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
            'index' => \Waynelogic\FilamentCms\Filament\Resources\BackendUserResource\Pages\ListBackendUsers::route('/'),
            'create' => \Waynelogic\FilamentCms\Filament\Resources\BackendUserResource\Pages\CreateBackendUser::route('/create'),
            'edit' => \Waynelogic\FilamentCms\Filament\Resources\BackendUserResource\Pages\EditBackendUser::route('/{record}/edit'),
        ];
    }
}
