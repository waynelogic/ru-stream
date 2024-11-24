<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StreamResource\Pages;
use App\Filament\Resources\StreamResource\RelationManagers;
use App\Models\Stream;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StreamResource extends Resource
{
    protected static ?string $model = Stream::class;
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'RU:Stream';
    protected static ?string $label = 'История';
    protected static ?string $pluralLabel = 'Истории';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationIcon = 'heroicon-o-device-phone-mobile';
    protected static ?string $activeNavigationIcon = 'heroicon-s-device-phone-mobile';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Видео')->schema([

                Forms\Components\TextInput::make('title')
                    ->label('Название')
                    ->required(),

                Forms\Components\Select::make('user_id')
                    ->label('Пользователь')
                    ->relationship('user', 'name')
                    ->required(),

                Forms\Components\Textarea::make('description')
                    ->label('Описание')
                    ->columnSpan('full'),

            ])->columns(3),

            SpatieMediaLibraryFileUpload::make('file')
                ->label('Видео')
                ->collection('videos'),

            SpatieMediaLibraryFileUpload::make('poster')
                ->label('Постер')
                ->collection('poster'),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Описание')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Пользователь')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('Тип')
                    ->badge()
                    ->searchable()
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
            'index' => Pages\ListStreams::route('/'),
            'create' => Pages\CreateStream::route('/create'),
            'edit' => Pages\EditStream::route('/{record}/edit'),
        ];
    }
}
