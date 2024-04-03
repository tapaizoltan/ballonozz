<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Pilot;
use App\Models\Region;
use App\Models\Aircraft;
use App\Models\Location;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Actions\Action;

/* saját use-ok */
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use App\Models\AircraftLocationPilot;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AircraftLocationPilotResource\Pages;
use App\Filament\Resources\AircraftLocationPilotResource\RelationManagers;

class AircraftLocationPilotResource extends Resource
{
    protected static ?string $model = AircraftLocationPilot::class;

    protected static ?string $navigationIcon = 'iconoir-database-script';
    protected static ?string $modelLabel = 'repülési terv';
    protected static ?string $pluralModelLabel = 'repülési tervek';

    protected static ?string $navigationGroup = 'Alapadatok';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(6)
                ->schema([
                    Section::make() 
                    ->schema([
                        Forms\Components\Fieldset::make('Tervezett repülés ideje')
                        ->schema([
                            DatePicker::make('date')
                                /*->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Adjon egy fantázianevet a légijárműnek. Érdemes olyan nevet választani, amivel könnyedén azonosítható lesz az adott légijármű.')*/
                                /*->helperText('Adjon egy fantázianevet a helyszínnek. Érdemes olyan nevet választani, amivel könnyedén azonosítható lesz az adott helyszín.')*/
                                ->label('Dátum')
                                ->prefixIcon('tabler-calendar')
                                ->weekStartsOnMonday()
                                //->placeholder(now())
                                ->displayFormat('Y-m-d')
                                ->required()
                                ->native(false),

                            TimePicker::make('time')
                                /*->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Ide a légijármű lajstromjelét adja meg.')*/
                                /*->helperText('Ide a légijármű lajstromjelét adja meg.')*/
                                ->label('Időpont')
                                ->prefixIcon('tabler-clock')
                                //->placeholder(now())
                                ->displayFormat('H:i:s')
                                ->required()
                                ->native(false),

                            Select::make('period_of_time')
                                ->label('Tervezett repülési idő')
                                ->options([
                                    '1' => '1 óra',
                                    '2' => '2 óra',
                                    '3' => '3 óra',
                                    '4' => '4 óra',
                                    '5' => '5 óra',
                                    '6' => '6 óra',
                                    '7' => '7 óra',
                                    '8' => '8 óra',
                                    '9' => '9 óra',
                                    '10' => '10 óra',
                                ])
                                ->prefixIcon('tabler-device-watch-check')
                                ->preload()
                                ->required()
                                ->native(false),
                            ])->columns(3),

                            Forms\Components\Fieldset::make('Tervezett repülés paraméterei')
                            ->schema([
                                Forms\Components\Select::make('aircraft_id')
                                    /*->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Ide a légijármű lajstromjelét adja meg.')*/
                                    /*->helperText('Ide a légijármű lajstromjelét adja meg.')*/
                                    ->label('Légijármű')
                                    ->prefixIcon('tabler-ufo')
                                    ->options(Aircraft::all()->pluck('name', 'id'))
                                    ->native(false)
                                    ->required()
                                    ->searchable(),
    
                                Forms\Components\Select::make('location_id')
                                    ->label('Helyszín')
                                    ->prefixIcon('iconoir-strategy')
                                    ->options(Location::all()->pluck('name', 'id'))
                                    ->native(false)
                                    ->required()
                                    ->searchable(),
    
                                Forms\Components\Select::make('pilot_id')
                                    /*->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Ide a légijármű lajstromjelét adja meg.')*/
                                    /*->helperText('Ide a légijármű lajstromjelét adja meg.')*/
                                    ->label('Pilóta')
                                    ->prefixIcon('iconoir-user-square')
                                    ->options(Pilot::all()->pluck('fullname', 'id')) // <-ez egy modell szinten deklarált atribútum
                                    ->native(false)
                                    ->searchable(),
                                ])->columns(3),

                        ])->columnSpan(4),

                        Section::make() 
                        ->schema([
                            Forms\Components\Fieldset::make('Státusz')
                            ->schema([
                                Forms\Components\ToggleButtons::make('status')
                                    /*->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Válassza ki a légijármű típusát.')*/
                                    ->helperText('A repülés terv státuszával megjelölheti az adott repülés állapotát.')
                                    ->label('Repülési terv státusza')
                                    ->inline()
                                    /*->grouped()*/
                                    ->required()
                                    ->options([
                                        '0' => 'Tervezett',
                                        '1' => 'Publikált',
                                        '2' => 'Véglegesített',
                                        '3' => 'Végrehajtott',
                                        '4' => 'Törölt',
                                    ])
                                    ->colors([
                                        '0' => 'warning',
                                        '1' => 'success',
                                        '2' => 'success',
                                        '3' => 'info',
                                        '4' => 'danger',
                                    ])
                                    ->icons([
                                        '0' => 'tabler-player-pause',
                                        '1' => 'tabler-player-play',
                                        '2' => 'tabler-flag-check',
                                        '3' => 'tabler-player-stop',
                                        '4' => 'tabler-playstation-x',
                                    ])
                                    ->default(0),
                                ])->columns(1),
                            ])->columnSpan(2),

                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')->label('Dátum')->searchable()
                ->description(function ($state, AircraftLocationPilot $name_of_the_day) {
                    $datesource = strtotime($state);
                    $day_name = date('D', $datesource);
                    if ($day_name == 'Mon'){$day_name = 'hétfő';}
                    if ($day_name == 'Tue'){$day_name = 'kedd';}
                    if ($day_name == 'Wed'){$day_name = 'szerda';}
                    if ($day_name == 'Thu'){$day_name = 'csütörtök';}
                    if ($day_name == 'Fri'){$day_name = 'péntek';}
                    if ($day_name == 'Sat'){$day_name = 'szombat';}
                    if ($day_name == 'Sun'){$day_name = 'vasárnap';}
                    return $day_name;
                }),
                TextColumn::make('time')->label('Időpont')->searchable()
                ->formatStateUsing(function ($state, AircraftLocationPilot $time) {
                    $timesource = strtotime($state);
                    $hour_source = date('G', $timesource);
                    $minute_source = date('i', $timesource);
                    return $hour_source.' óra '.$minute_source.' perc';
                }),
                TextColumn::make('period_of_time')->label('Tervezett repülési idő')
                ->formatStateUsing(function ($state, AircraftLocationPilot $period) {
                    return $period->period_of_time . ' óra';
                }),
                TextColumn::make('location_id')->label('Helyszín')->searchable()
                ->formatStateUsing(function ($state, AircraftLocationPilot $aircraft_localtion_pilot) {
                    $location_name = Location::find($aircraft_localtion_pilot->location_id);
                    return $location_name->name;
                })
                ->description(function ($state, AircraftLocationPilot $aircraft_localtion_pilot) {
                    $location_id = Location::find($aircraft_localtion_pilot->location_id);
                    $region_id = $location_id->id;
                    $region_name = Region::find($region_id);
                    return $region_name->name;
                }),
                TextColumn::make('aircraft_id')->label('Légijármű')->searchable()
                ->formatStateUsing(function ($state, AircraftLocationPilot $aircraft_localtion_pilot) {
                    $aircraft_name = Aircraft::find($aircraft_localtion_pilot->aircraft_id);
                    return $aircraft_name->name;
                }),
                TextColumn::make('pilot.fullname')->label('Pilóta')->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Státusz')
                    ->badge()
                    ->size('md'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('checkins')
                    ->label('Jelentkezők')
                    ->badge(function ($record) {
                        if ($record->coupons->count()) {
                            return $record->coupons->count();
                        }

                        return null;
                    })
                    ->hidden(fn ($record) => !$record->coupons->count())
                    ->action(fn ($record) => redirect(route('filament.admin.resources.aircraft-location-pilots.checkins', $record->id))),
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
            'index' => Pages\ListAircraftLocationPilots::route('/'),
            'create' => Pages\CreateAircraftLocationPilot::route('/create'),
            /*'view' => Pages\ViewAircraftLocationPilot::route('/{record}'),*/
            'edit' => Pages\EditAircraftLocationPilot::route('/{record}/edit'),
            'checkins' => Pages\ListCheckins::route('/{record}/checkins'),
        ];
    }

    public static function getNavigationBadge(): ?string //ez kiírja a menü mellé, hogy mennyi publikált repülési terv van
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = static::$model;

        return (string) $modelClass::where('status', '1')->count();
    }
}
