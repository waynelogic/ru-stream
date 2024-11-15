<?php

namespace Waynelogic\FilamentBlog\Filament\Resources;

use Illuminate\Support\Str;
use Waynelogic\FilamentBlog\Filament\Resources\PostResource\Pages;
use Waynelogic\FilamentBlog\Filament\Resources\PostResource\RelationManagers;
use Waynelogic\FilamentBlog\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationGroup = 'Блог';
    protected static ?string $label = 'Пост';
    protected static ?string $pluralLabel = 'Записи';
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';
    protected static ?string $activeNavigationIcon = 'heroicon-s-document-duplicate';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Заголовок')
                        ->required()
                        ->live(onBlur: true)
                        ->maxLength(255)
                        ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                    Forms\Components\TextInput::make('slug')
                        ->dehydrated()
                        ->required()
                        ->maxLength(255)
                        ->unique(Post::class, 'slug', ignoreRecord: true),

                    Forms\Components\RichEditor::make('content')
                        ->label('Содержание')
                        ->required()
                        ->columnSpan('full'),

//                    Forms\Components\Select::make('category_id')
//                        ->label('Категория')
//                        ->relationship('category', 'name'),

                    Forms\Components\DateTimePicker::make('published_at')
                        ->required()
                        ->default(now())
                        ->label('Опубликовано'),

//                    SpatieTagsInput::make('tags'),
                ])
                ->columns(2),

            Forms\Components\Section::make('Image')
                ->schema([
                    Forms\Components\FileUpload::make('image')
                        ->image()
                        ->hiddenLabel(),
                ])
                ->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Заголовок')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->getStateUsing(fn (Post $record): string => $record->published_at?->isPast() ? 'Опубликован' : 'Черновик')
                    ->colors([
                        'success' => 'Опубликован',
                    ]),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Категория')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Опубликовано')
                    ->sortable()
                    ->date(),
            ])
            ->defaultSort('published_at')
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
