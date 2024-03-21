<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TickettypeResource\Pages;
use App\Filament\Resources\TickettypeResource\RelationManagers;
use App\Models\Tickettype;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

/* saját use-ok */
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

class TickettypeResource extends Resource
{
    protected static ?string $model = Tickettype::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $modelLabel = 'jegytípus';
    protected static ?string $pluralModelLabel = 'jegytípusok';

    protected static ?string $navigationGroup = 'Alapadatok';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(6)
                ->schema([
                    Section::make() 
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            /*->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Adjon egy fantázianevet a légijárműnek. Érdemes olyan nevet választani, amivel könnyedén azonosítható lesz az adott légijármű.')*/
                            ->helperText('Adjon egy fantázianevet a jegytípusnak. Érdemes olyan nevet választani, amivel könnyedén azonosítható lesz az adott jegytípus és a hozzá társított paraméterek.')
                            ->label('Megnevezés')
                            ->prefixIcon('tabler-writing-sign')
                            ->required()
                            ->minLength(3)
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            /*->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Adjon egy fantázianevet a légijárműnek. Érdemes olyan nevet választani, amivel könnyedén azonosítható lesz az adott légijármű.')*/
                            ->rows(8)
                            ->cols(20)
                            ->autosize()
                            ->helperText('Itt néhány sorban leírhatja ennek a jegytípusnak a jellemzőit.')
                            ->label('Leírás'),
                    ])->columnSpan(2),

                    Section::make() 
                    ->schema([
                            Forms\Components\Fieldset::make('Utasok száma')
                            ->schema([
                                Forms\Components\TextInput::make('adult')
                                ->helperText('Adja meg a jegytípushoz tartozó felnőtt utasok számát.')
                                ->label('Felnőtt')
                                ->prefixIcon('tabler-friends')
                                ->required()
                                ->numeric()
                                ->default(0)
                                ->minValue(1)
                                ->minLength(1)
                                ->maxLength(2)
                                ->suffix(' fő'),

                                Forms\Components\TextInput::make('children')
                                ->helperText('Adja meg a jegytípushoz tartozó gyermek utasok számát.')
                                ->label('Gyerek')
                                ->prefixIcon('tabler-horse-toy')
                                ->required()
                                ->numeric()
                                ->default(0)
                                ->minLength(1)
                                ->maxLength(2)
                                ->suffix(' fő'),

                            ])->columns(2),
                            
                            Forms\Components\Fieldset::make('Extra beállítások')
                            ->schema([
                                Forms\Components\Toggle::make('vip')
                                ->inline(false)
                                ->onColor('success')
                                ->onIcon('tabler-check')
                                ->offIcon('tabler-x')
                                ->helperText('Kapcsolja be amennyiben ez egy VIP jegytípus.')
                                ->label('VIP')
                                ->default(0),
                            Forms\Components\Toggle::make('private')
                                ->inline(false)
                                ->onColor('success')
                                ->onIcon('tabler-check')
                                ->offIcon('tabler-x')
                                ->helperText('Kapcsolja be amennyiben ez egy Privát jegytípus.')
                                ->label('Privát')
                                ->default(0),

                            ])->columns(2),

                        ])->columnSpan(2),
                    
                        Section::make() 
                        ->schema([
                            Forms\Components\Fieldset::make('Forrás beállítások')
                            ->schema([
                                Forms\Components\TextInput::make('source')
                                ->helperText('itt rögzítheti, hogy melyik szolgáltatótól érkezik az erre a jegyre vonatkozó hivatkozás. pl.: Meglepkék')
                                ->label('Forrás')
                                ->prefixIcon('tabler-writing-sign')
                                ->required()
                                ->minLength(3)
                                ->maxLength(255),
                            Forms\Components\TextInput::make('name_stored_at_source')
                                ->helperText('Rögzítse, hogy a forrásnál milyen néven szerepel az adott jegytípus.')
                                ->label('Forrásnál tárol megnevezés')
                                ->prefixIcon('tabler-writing-sign')
                                ->required()
                                ->minLength(3)
                                ->maxLength(255),
                                ])->columns(1),

                            Forms\Components\Fieldset::make('Társított légijárművek')
                                ->schema([
                                    Forms\Components\Select::make('aircrafts')
                                        ->label(false)
                                        ->helperText('Itt rögzíthet több légijárművet az adott jegytípushoz.')
                                        ->multiple()
                                        ->relationship(titleAttribute: 'name')
                                        ->preload(),
                                        /*
                                        ->createOptionForm([
                                            Forms\Components\TextInput::make('name')
                                                ->required()->unique(),]),
                                                */
                                ])->columns(1),

                            ])->columnSpan(2),
                ]), 

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('name')
                ->label('Megnevezés')
                ->description(fn (Tickettype $record): string => $record->description)
                ->wrap()
                ->searchable(),

            Tables\Columns\TextColumn::make('source')
                ->label('Forrás')
                ->description(fn (Tickettype $record): string => $record->name_stored_at_source)
                ->wrap()
                ->searchable(),
            Tables\Columns\TextColumn::make('adult')
                ->label('Utasok')
                ->formatStateUsing(function ($state, Tickettype $payload) {
                    return '<p style="color:gray; font-size:9pt;"><b style="color:white; font-size:11pt; font-weight:normal;">'.$payload->adult . '</b> felnőtt</p><p style="color:gray; font-size:9pt;"><b style="color:white; font-size:11pt; font-weight:normal;">' . $payload->children . '</b> gyerek</p>';
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

            Tables\Columns\TextColumn::make('aircrafts.name')
                ->label('Társított légijárművek')
                ->searchable()
                ->wrap()
                ->badge()
                ->size('sm'),
        ])
            ->filters([
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
            'index' => Pages\ListTickettypes::route('/'),
            'create' => Pages\CreateTickettype::route('/create'),
            'edit' => Pages\EditTickettype::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationBadge(): ?string //ez kiírja a menü mellé, hogy mennyi jegytípus van már rögzítve
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = static::$model;

        return (string) $modelClass::all()->count();
    }
}
