<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InstructionResource\Pages;
use App\Filament\Resources\InstructionResource\RelationManagers;
use App\Models\Instruction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InstructionResource extends Resource
{
    protected static ?string $model = Instruction::class;

    protected static ?string $navigationGroup = 'RU:Stream';

    protected static ?string $label = 'Инструкция';

    protected static ?string $pluralLabel = 'Инструкции';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationIcon = 'phosphor-airplay';

    protected static ?string $activeNavigationIcon = 'phosphor-airplay-fill';


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
                ->view('rustream::filament.fields.video-frame'),

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
                    ->url( function (Instruction $record) {
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
            'index' => Pages\ListInstructions::route('/'),
            'create' => Pages\CreateInstruction::route('/create'),
            'edit' => Pages\EditInstruction::route('/{record}/edit'),
        ];
    }
}
