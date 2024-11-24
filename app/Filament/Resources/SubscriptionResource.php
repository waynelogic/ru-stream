<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionResource\Pages;
use App\Filament\Resources\SubscriptionResource\RelationManagers;
use App\Models\Subscription;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;
    protected static ?string $navigationGroup = 'Магазин';
    protected static ?string $label = 'Подписка';
    protected static ?string $pluralLabel = 'Подписки';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $activeNavigationIcon = 'heroicon-s-book-open';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Связи')->schema([
                Forms\Components\Select::make('pricing_plan_id')
                    ->label('План')
                    ->prefixIcon('heroicon-s-square-3-stack-3d')
                    ->relationship('pricing_plan', 'name')
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->label('Пользователь')
                    ->prefixIcon('heroicon-s-user')
                    ->relationship('user', 'name')
                    ->required(),
            ])->columns(2),

            Forms\Components\Section::make('Даты')->schema([
                Forms\Components\DateTimePicker::make('start_at')
                    ->label('Начало')
                    ->prefixIcon('heroicon-s-play')
                    ->required(),

                Forms\Components\DateTimePicker::make('end_at')
                    ->label('Конец')
                    ->prefixIcon('heroicon-s-stop')
                    ->required(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pricing_plan.name')
                    ->label('План')
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Пользователь')
                    ->searchable(),

                Tables\Columns\TextColumn::make('start_at')
                    ->label('Начало')
                    ->searchable(),

                Tables\Columns\TextColumn::make('end_at')
                    ->label('Конец')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->groups([
                Tables\Grouping\Group::make('user.login')
                    ->label('Пользователь'),
            ])
            ->defaultGroup('user.login')
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
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}
