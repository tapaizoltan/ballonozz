<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Coupon;
use Faker\Core\Number;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Passenger;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use App\Filament\Resources\CouponResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CouponResource\RelationManagers;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $modelLabel = 'kupon';
    protected static ?string $pluralModelLabel = 'kuponok';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(12)
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('coupon_code')
                                    /*->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Adjon egy fantázianevet a légijárműnek. Érdemes olyan nevet választani, amivel könnyedén azonosítható lesz az adott légijármű.')*/
                                    ->helperText('Adja meg a már korábban megkapott kuponkódját.')
                                    ->label('Kuponkód')
                                    ->prefixIcon('iconoir-password-cursor')
                                    ->placeholder('ABC-'. random_int(100000, 999999))
                                    ->required()
                                    ->minLength(3)
                                    ->maxLength(255),
                                
                                Actions::make([
                                    Forms\Components\Actions\Action::make('Ellenőrzés')
                                        ->action(function (Forms\Get $get, Forms\Set $set) {
                                            //$set('coupon_code', str($get('content'))->words(45, end: ''));
                                        })
                                ]),

                                Fieldset::make('Forrás')
                                    ->hiddenOn('edit')
                                    ->schema([
                                        ToggleButtons::make('source')
                                            ->helperText('Válassza ki honnan származik az adott kupon.')
                                            ->label('Válasszon')
                                            ->inline()
                                            ->required()
                                            ->default('Meglepkék')
                                            ->disabledOn('edit')
                                            ->options([
                                                'Meglepkék' => 'Meglepkék',
                                                'Ballonozz' => 'Ballonozz.hu',
                                                'Egyéb' => 'Egyéb',
                                            ])
                                            ->icons([
                                                'Meglepkék' => 'iconoir-hot-air-balloon',
                                                'Ballonozz' => 'tabler-butterfly',
                                                'Egyéb' => 'tabler-progress-help',
                                            ])
                                            ->colors([
                                                'Meglepkék' => 'info',
                                                'Ballonozz' => 'info',
                                                'Egyéb' => 'info',
                                            ]),
                                    ])->columns(1),
                            ])->columnSpan(4),

                        Section::make()
                            ->schema([
                                Fieldset::make('Utasok száma')
                                    ->schema([
                                        TextInput::make('adult')
                                            ->helperText('Adja meg a kuponhoz tartozó felnőtt utasok számát.')
                                            ->label('Felnőtt')
                                            ->prefixIcon('tabler-friends')
                                            ->required()
                                            ->disabledOn('edit')
                                            ->numeric()
                                            ->default(0)
                                            ->minValue(1)
                                            ->minLength(1)
                                            ->maxLength(10)
                                            //->live()
                                            //->afterStateUpdated(fn ($state) => dd($state))
                                            ->reactive()
                                            ->suffix(' fő'),
                                            
                                        TextInput::make('children')
                                            ->helperText('Adja meg a kuponhoz tartozó gyermek utasok számát.')
                                            ->label('Gyermek')
                                            ->prefixIcon('tabler-horse-toy')
                                            ->required()
                                            ->disabledOn('edit')
                                            ->numeric()
                                            ->default(0)
                                            ->minLength(1)
                                            ->maxLength(10)
                                            ->suffix(' fő'),

                                    ])->columns(2),

                                Fieldset::make('Extra beállítások')
                                    ->schema([
                                        Forms\Components\Toggle::make('vip')
                                            ->inline(false)
                                            ->onColor('success')
                                            ->onIcon('tabler-check')
                                            ->offIcon('tabler-x')
                                            ->helperText('Kapcsolja be amennyiben ez egy VIP kupon.')
                                            ->label('VIP')
                                            ->disabledOn('edit')
                                            ->default(0),
                                        Forms\Components\Toggle::make('private')
                                            ->inline(false)
                                            ->onColor('success')
                                            ->onIcon('tabler-check')
                                            ->offIcon('tabler-x')
                                            ->helperText('Kapcsolja be amennyiben ez egy Privát kupon.')
                                            ->label('Privát')
                                            ->disabledOn('edit')
                                            ->default(0),

                                    ])->columns(2),
                            ])->columnSpan(4),
                        Hidden::make('status')->default('1'),
                    ]),
                    
                    Grid::make(12)
                    ->schema([
                        Section::make()    
                        ->schema([
                                Repeater::make('passengers')
                                //->hidden(fn (Get $get) => $get('adult') === 0)
                                ->addActionLabel('Új utas felvétele')
                                ->label('Utasok')
                                ->relationship()
                                //->defaultItems(1)

                                //->defaultItems(fn (Get $get) => $get('adult') ?? 0)

                                //->reorderable(true)
                                //->reorderableWithButtons()
                                //->collapsible()
                                //->collapsed()
                                //->cloneable()
                                //->disabled()
                                //->orderColumn('firstname')
                                //->itemLabel(fn (array $state): ?string => $state['lastname'] ?? null)
                                ->schema([
                                    TextInput::make('lastname')
                                    ->label('Vezetéknév')
                                    ->prefixIcon('tabler-writing-sign')
                                    ->placeholder('pl.: Gipsz')
                                    ->required()
                                    ->minLength(3)
                                    ->maxLength(255),
                                    TextInput::make('firstname')
                                    ->label('Keresztnév')
                                    ->prefixIcon('tabler-writing-sign')
                                    ->placeholder('Jakab')
                                    ->required()
                                    ->minLength(3)
                                    ->maxLength(255),
                                    DatePicker::make('date_of_birth')
                                    ->label('Születési dátum')
                                    ->prefixIcon('tabler-calendar')
                                    ->weekStartsOnMonday()
                                    ->displayFormat('Y-m-d')
                                    ->required()
                                    ->native(false),
                                    TextInput::make('id_card_number')
                                    ->label('Igazolvány szám')
                                    ->prefixIcon('tabler-id')
                                    ->placeholder('432654XX')
                                    ->required()
                                    ->minLength(3)
                                    ->maxLength(10),
                                    TextInput::make('body_weight')
                                    ->label('Testsúly')
                                    ->prefixIcon('iconoir-weight-alt')
                                    ->required()
                                    ->numeric()
                                    ->minLength(1)
                                    ->maxLength(10)
                                    ->suffix(' kg'),
                                ])->columns(5),
                            ]),
                        ])->columnSpan(12),
                    ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('coupon_code')
                    ->label('Kuponkód')
                    ->description(fn (Coupon $record): string => $record->source)
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('adult')
                    ->label('Utasok')
                    ->formatStateUsing(function ($state, Coupon $payload) {
                        return '<p style="color:gray; font-size:9pt;"><b style="color:white; font-size:11pt; font-weight:normal;">' . $payload->adult . '</b> felnőtt</p><p style="color:gray; font-size:9pt;"><b style="color:white; font-size:11pt; font-weight:normal;">' . $payload->children . '</b> gyerek</p>';
                    })->html()
                    ->searchable(),
                Tables\Columns\TextColumn::make('vip')
                    ->label(false)
                    ->badge()
                    ->size('sm'),
                Tables\Columns\TextColumn::make('private')
                    ->label(false)
                    ->badge()
                    ->size('sm'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Státusz')
                    ->badge()
                    ->size('md'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->hiddenLabel()->tooltip('Megtekintés')->link(),
                Tables\Actions\EditAction::make()->hiddenLabel()->tooltip('Szerkesztés')->link(),
                /*
                Tables\Actions\Action::make('delete')->icon('heroicon-m-trash')->color('danger')->hiddenLabel()->tooltip('Törlés')->link()->requiresConfirmation()->action(fn ($record) => $record->delete()),
                */
                Tables\Actions\DeleteAction::make()->label(false)->tooltip('Törlés'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Mind törlése'),
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
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string //ez kiírja a menü mellé, hogy mennyi publikált repülési terv van
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = static::$model;

        return (string) $modelClass::where('status', '0')->count();
    }
}
