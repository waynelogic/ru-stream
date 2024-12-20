<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Администрирование';
    protected static ?string $label = 'Пользователь';
    protected static ?string $pluralLabel = 'Пользователи';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $activeNavigationIcon = 'heroicon-s-user-circle';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Group::make()->schema([

                Forms\Components\Section::make('Пользователь')->schema([

                    Forms\Components\TextInput::make('name')
                        ->label('Имя')
                        ->required(),

                    Forms\Components\TextInput::make('login')
                        ->label('Логин')
                        ->required(),

                    Forms\Components\TextInput::make('email')
                        ->label('E-mail')
                        ->email()
                        ->required(),

                    Forms\Components\Select::make('partner_id')
                        ->label('Партнер')
                        ->relationship(name: 'partner', titleAttribute: 'email'),

                    Forms\Components\TextInput::make('balance')
                        ->label('Баланс')
                        ->numeric(),

                ])->columns(2),

            ])->columnSpan(['lg' => 2 ]),


            Forms\Components\Group::make()->schema([

                Forms\Components\Section::make('Данные')->schema([

                    Forms\Components\Placeholder::make('created_at')
                        ->label('Дата создания')
                        ->content(fn (User $record): ?string => $record->created_at?->diffForHumans()),

                    Forms\Components\Placeholder::make('updated_at')
                        ->label('Последнее обновление')
                        ->content(fn (User $record): ?string => $record->updated_at?->diffForHumans()),

                ]),

            ])->columnSpan(['lg' => 1 ]),




        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('name')
                    ->label('Имя'),

                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail'),
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

    public static function getNavigationBadge(): ?string
    {
        $modelClass = static::$model;

        return (string) $modelClass::count();
    }

    public static function getRelations(): array
    {
        return [
            UserResource\RelationManagers\VideosRelationManager::class,
            UserResource\RelationManagers\StoriesRelationManager::class,
            UserResource\RelationManagers\ReferredRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
