<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use App\Models\Aircraft;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;

/* saját use-ok */
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use App\Filament\Resources\AircraftResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AircraftResource\RelationManagers;

class AircraftResource extends Resource
{
    protected static ?string $model = Aircraft::class;

    protected static ?string $navigationIcon = 'iconoir-airplane-rotation';
    protected static ?string $modelLabel = 'légijármű';
    protected static ?string $pluralModelLabel = 'légijárművek';

    protected static ?string $navigationGroup = 'Alapadatok';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(4)
                ->schema([
                    Section::make() 
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            /*->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Adjon egy fantázianevet a légijárműnek. Érdemes olyan nevet választani, amivel könnyedén azonosítható lesz az adott légijármű.')*/
                            ->helperText('Adjon egy fantázianevet a légijárműnek. Érdemes olyan nevet választani, amivel könnyedén azonosítható lesz az adott légijármű.')
                            ->label('Megnevezés')
                            ->prefixIcon('tabler-writing-sign')
                            ->required()
                            ->minLength(3)
                            ->maxLength(255),
                            Forms\Components\Fieldset::make('Besorolás')
                            ->schema([
                                Forms\Components\ToggleButtons::make('type')
                                    /*->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Válassza ki a légijármű típusát.')*/
                                    ->helperText('Válassza ki a légijármű típusát.')
                                    ->label('Típus')
                                    ->inline()
                                    /*->grouped()*/
                                    ->required()
                                    ->options([
                                        '0' => 'Hőlégballon',
                                        '1' => 'Kisrepülő',
                                    ])
                                    ->icons([
                                        '0' => 'iconoir-hot-air-balloon',
                                        '1' => 'iconoir-airplane',
                                    ])
                                    ->colors([
                                        '0' => 'info',
                                        '1' => 'info',
                                    ])
                                    ->default(0),
                                Forms\Components\TextInput::make('registration_number')
                                    /*->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Ide a légijármű lajstromjelét adja meg.')*/
                                    ->helperText('Ide a légijármű lajstromjelét adja meg.')
                                    ->label('Lajstrom-jel')
                                    ->prefixIcon('tabler-license')
                                    ->placeholder('HA-1234 vagy HA-ABCD')
                                    ->required()
                                    ->minLength(3)
                                    ->maxLength(10),
                                ])->columns(2),
                    ])->columnSpan(2),

                    Section::make() 
                    ->schema([
                        Forms\Components\Fieldset::make('Terhelhetőség')
                        ->schema([
                            Forms\Components\TextInput::make('number_of_person')
                            ->helperText('Adja meg a MAXIMÁLISAN szállítható személyek számát.')
                            ->label('Szállítható személyek száma')
                            ->prefixIcon('fluentui-people-team-24-o')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minLength(1)
                            ->maxLength(10)
                            ->suffix(' fő'),

                            Forms\Components\TextInput::make('payload_capacity')
                            ->helperText('Adja meg a légijármű a pilótával együttes MAXIMÁLIS terhetőségét kg-ban.')
                            ->label('Terhetőség')
                            ->prefixIcon('tabler-weight')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->step(10)
                            ->minLength(2)
                            ->maxLength(10)
                            ->suffix(' kg'),

                        ])->columns(2),
                        /*
                        Forms\Components\Fieldset::make('Extra beállítások')
                            ->schema([
                                Toggle::make('unlimited')
                                    ->inline(false)
                                    ->onColor('success')
                                    ->onIcon('tabler-check')
                                    ->offIcon('tabler-x')
                                    ->helperText('Amennyiben ez be van kapcsolva, erre a légijárműre korlátlan számú utas jelentkezhet.')
                                    ->label('Korlátlan utasszám')
                                    ->default(0)
                                    ->live()
                                    ->disabled(fn (GET $get): bool => ($get('vip')!='0') || ($get('private')!='0'))
                                    ->dehydrated(true),

                                Toggle::make('vip')
                                    ->inline(false)
                                    ->onColor('success')
                                    ->onIcon('tabler-check')
                                    ->offIcon('tabler-x')
                                    ->helperText('Kapcsolja be amennyiben ez a légijármű VIP jegytípussal is használható.')
                                    ->label('VIP')
                                    ->default(0)
                                    ->live()
                                    ->disabled(fn (GET $get): bool => ($get('unlimited')!='0'))
                                    ->dehydrated(true),

                                Toggle::make('private')
                                    ->inline(false)
                                    ->onColor('success')
                                    ->onIcon('tabler-check')
                                    ->offIcon('tabler-x')
                                    ->helperText('Kapcsolja be amennyiben ez a légijármű PRIVÁT jegytípussal is használható.')
                                    ->label('Privát')
                                    ->default(0)
                                    ->live()
                                    ->disabled(fn (GET $get): bool => ($get('unlimited')!='0'))
                                    ->dehydrated(true),

                            ])->columns(3),*/
                        
                            Forms\Components\Fieldset::make('Társított jegytípusok')
                            ->schema([
                                Select::make('tickettypes')
                                ->label('Jegytípusok')
                                ->multiple()
                                ->relationship(titleAttribute: 'name')
                                ->preload(),
                                ])->columns(1),

                    ])->columnSpan(2),
                ]), 
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Megnevezés')->searchable(),
                TextColumn::make('type')
                    ->label('Típus')
                    ->badge()
                    ->size('md'),
                TextColumn::make('registration_number')->label('Lajtsrom-jel')->searchable(),
                TextColumn::make('number_of_person')->label('Száll.szem.száma')->searchable()
                    ->formatStateUsing(fn($state)=>$state.' fő'),
                TextColumn::make('payload_capacity')->label('Max. terhelhetőség')->searchable()
                    ->formatStateUsing(fn($state)=>$state.' kg'),
                /*
                IconColumn::make('unlimited')
                    ->label('Extra')
                    ->tooltip('Korlátlan utasszám felvétele')
                    ->boolean()
                    ->trueIcon('tabler-infinity')
                    ->falseIcon('tabler-infinity-off')
                    //->falseIcon('tabler-infinity')
                    //->falseIcon('')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->width(20)
                    ->size(IconColumn\IconColumnSize::Medium),
                IconColumn::make('vip')
                    ->label('')
                    ->tooltip('VIP')
                    ->boolean()
                    ->trueIcon('tabler-vip')
                    //->falseIcon('tabler-vip')
                    ->falseIcon('')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->width(20)
                    ->size(IconColumn\IconColumnSize::Medium),
                IconColumn::make('private')
                    ->label('')
                    ->tooltip('PRIVATE')
                    ->boolean()
                    ->trueIcon('tabler-crown')
                    //->falseIcon('tabler-crown')
                    ->falseIcon('')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->size(IconColumn\IconColumnSize::Medium),
                */
            ])
            ->filters([
                Tables\Filters\Filter::make('type')
                    ->query(fn (Builder $query) => $query->where('type', true)),
                    Tables\Filters\SelectFilter::make('type')
                    ->label('Típus')
                    ->options([
                        '0' => 'Hőlégballon',
                        '1' => 'Kisrepülő',
                    ])
                    ->native(false),
                Tables\Filters\TrashedFilter::make()->native(false),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->hiddenLabel()->tooltip('Megtekintés')->link(),
                Tables\Actions\EditAction::make()->hiddenLabel()->tooltip('Szerkesztés')->link(),
                /*
                Tables\Actions\Action::make('delete')->icon('heroicon-m-trash')->color('danger')->hiddenLabel()->tooltip('Törlés')->link()->requiresConfirmation()->action(fn ($record) => $record->delete()),
                */
                Tables\Actions\DeleteAction::make()->label(false)->tooltip('Törlés'),
                Tables\Actions\ForceDeleteAction::make()->label(false)->tooltip('Végleges törlés'),
                Tables\Actions\RestoreAction::make()->label(false)->tooltip('Helyteállítás'),
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
            'index' => Pages\ListAircraft::route('/'),
            'create' => Pages\CreateAircraft::route('/create'),
            /*'view' => Pages\ViewAircraft::route('/{record}'),*/
            'edit' => Pages\EditAircraft::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationBadge(): ?string //ez kiírja a menü mellé, hogy mennyi légijármű van már rögzítve
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = static::$model;

        return (string) $modelClass::all()->count();
    }
}
