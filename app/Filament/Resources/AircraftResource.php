<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AircraftResource\Pages;
use App\Filament\Resources\AircraftResource\RelationManagers;
use App\Models\Aircraft;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


/* saját use-ok */
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Contracts\HasLabel;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Fieldset;

class AircraftResource extends Resource
{
    protected static ?string $model = Aircraft::class;

    protected static ?string $navigationIcon = 'iconoir-airplane-rotation';
    protected static ?string $modelLabel = 'légijármű';
    protected static ?string $pluralModelLabel = 'légijárművek';

    protected static ?string $navigationGroup = 'Alapadatok';
    protected static ?int $navigationSort = 1;

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
                    ])->columnSpan(3),
                ]), 

                Grid::make(4)
                ->schema([
                    Section::make() 
                    ->schema([
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
                            ])->columns(2)
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

                            ])->columns(2)
                        ])->columnSpan(2)
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Megnevezés')->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Típus')
                    ->badge()
                    ->size('md'),
                    Tables\Columns\TextColumn::make('registration_number')->label('Lajtsrom-jel')->searchable(),
                    Tables\Columns\TextColumn::make('number_of_person')->label('Száll.szem.száma')->searchable()
                    ->formatStateUsing(fn($state)=>$state.' fő'),
                    Tables\Columns\TextColumn::make('payload_capacity')->label('Max. terhelhetőség')->searchable()
                    ->formatStateUsing(fn($state)=>$state.' kg'),

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
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->hiddenLabel()->tooltip('Megtekintés')->link(),
                Tables\Actions\EditAction::make()->hiddenLabel()->tooltip('Szerkesztés')->link(),
                Tables\Actions\Action::make('delete')->icon('heroicon-m-trash')->color('danger')->hiddenLabel()->tooltip('Törlés')->link()->requiresConfirmation()->action(fn ($record) => $record->delete()),
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
}
