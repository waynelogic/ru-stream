<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CaseItemResource\Pages;
use App\Filament\Resources\CaseItemResource\RelationManagers;
use App\Models\CaseItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CaseItemResource extends Resource
{
    protected static ?string $model = CaseItem::class;

    protected static ?string $navigationGroup = 'RU:Stream';

    protected static ?string $label = 'Кейс';
    protected static ?string $pluralLabel = 'Кейсы';
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $activeNavigationIcon = 'heroicon-s-briefcase';


    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Основное')->schema([

                Forms\Components\TextInput::make('title')
                    ->label('Заголовок')
                    ->required(),

                Forms\Components\TextInput::make('video_url')
                    ->label('Ссылка на видео')
                    ->url()
                    ->live(onBlur: true)
                    ->required(),

            ])->columns(2),

            Forms\Components\ViewField::make('video_frame')
                ->label('Видео')
                ->live()
                ->view('filament.fields.video-frame'),

            Forms\Components\Textarea::make('description')
                ->label('Описание'),

            Forms\Components\Toggle::make('active')
                ->label('Активен')
                ->default(true),

        ])->columns([ 'lg' => 2, ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Заголовок'),
                Tables\Columns\TextColumn::make('video_url')
                    ->label('Ссылка на видео')
                    ->url( function (CaseItem $record) {
                        return $record->video_url;
                    })
                    ->openUrlInNewTab(),
                Tables\Columns\ToggleColumn::make('active')
                    ->label('Активен'),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
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
            'index' => Pages\ListCaseItems::route('/'),
            'create' => Pages\CreateCaseItem::route('/create'),
            'edit' => Pages\EditCaseItem::route('/{record}/edit'),
        ];
    }
}
