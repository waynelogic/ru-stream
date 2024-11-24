<?php namespace App\Filament\Resources;

use App\Enums\StreamType;
use App\Filament\Resources\PricingPlanResource\Pages;
use App\Filament\Resources\PricingPlanResource\RelationManagers;
use App\Models\PricingPlan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PricingPlanResource extends Resource
{
    protected static ?string $model = PricingPlan::class;
    protected static ?string $navigationGroup = 'Магазин';
    protected static ?string $label = 'Тарифы';
    protected static ?string $pluralLabel = 'Тарифы';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $activeNavigationIcon = 'heroicon-s-book-open';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Group::make([

                Forms\Components\Section::make('Основное')->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Название')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                            if ($operation !== 'create') return;

                            $set('slug', Str::slug($state));
                        }),

                    Forms\Components\TextInput::make('slug')
                        ->dehydrated()
                        ->required()
                        ->maxLength(255)
                        ->unique(PricingPlan::class, 'slug', ignoreRecord: true),

                    Forms\Components\RichEditor::make('description')
                        ->label('Описание')
                        ->columnSpan('full'),

                ])->columns(2),

                Forms\Components\Section::make('Возможности')->schema([

                    Forms\Components\TextInput::make('max_accounts_count')
                        ->label('Максимальное количество аккаунтов')
                        ->numeric()
                        ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                        ->required(),

                    Forms\Components\TextInput::make('max_streams_count')
                        ->label('Максимальное количество трансляций')
                        ->numeric()
                        ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                        ->required(),

                ])->columns(2),

            ])->columnSpan(['lg' => 2]),


            Forms\Components\Group::make([
                Forms\Components\Section::make('Подписка')->schema([

                    Forms\Components\Select::make('type')
                        ->label('Тип')
                        ->options(StreamType::class)
                        ->required(),

                    Forms\Components\TextInput::make('monthly_price')
                        ->label('Месячная цена')
                        ->prefixIcon('heroicon-o-banknotes')
                        ->numeric()
                        ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                        ->required(),

                    Forms\Components\TextInput::make('yearly_price')
                        ->label('Годовая цена')
                        ->prefixIcon('heroicon-o-banknotes')
                        ->numeric()
                        ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                        ->required(),

                    Forms\Components\Toggle::make('most_popular')
                        ->label('Популярный'),
                ]),
            ]),

        ])->columns(['lg' => 3]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Тип')
                    ->badge()
                    ->searchable()
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('most_popular')
                    ->label('Популярный')
            ])
            ->filters([
//                Tables\Grouping\Group::make('type')
//                    ->label('Тип'),
            ])
            ->defaultGroup('type')
            ->groups([
                Tables\Grouping\Group::make('type')
                    ->label('Тип'),
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
            'index' => Pages\ListPricingPlans::route('/'),
            'create' => Pages\CreatePricingPlan::route('/create'),
            'edit' => Pages\EditPricingPlan::route('/{record}/edit'),
        ];
    }
}
