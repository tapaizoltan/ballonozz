<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Tickettype;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\TickettypeAircraft;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;

/* saját use-ok */
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TickettypeAircraftResource\Pages;
use App\Filament\Resources\TickettypeAircraftResource\RelationManagers;
use App\Models\Aircraft;

class TickettypeAircraftResource extends Resource
{
    protected static ?string $model = TickettypeAircraft::class;

    protected static ?string $navigationIcon = 'tabler-hand-move';
    protected static ?string $modelLabel = 'jegytípus társítás';
    protected static ?string $pluralModelLabel = 'jegytípusok társításai';

    protected static ?string $navigationGroup = 'Alapadatok';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Grid::make(4)
                ->schema([
                    Section::make() 
                    ->schema([
                        Forms\Components\Fieldset::make('Jegytípus társítása légijárműhöz')
                        ->schema([
                            Forms\Components\Select::make('tickettype_id')
                                ->label('Jegytípus')
                                ->prefixIcon('heroicon-o-ticket')
                                ->options(Tickettype::all()->pluck('name', 'id'))
                                ->searchable()
                                ->native(false),

                            Forms\Components\Select::make('aircraft_id')
                                ->label('Légijármű')
                                ->prefixIcon('iconoir-airplane-rotation')
                                ->options(Aircraft::all()->pluck('name', 'id'))
                                ->searchable()
                                ->native(false),
                            
                            ])->columns(2),

                        ])->columnSpan(3),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tickettype_id')->label('Jegytípus')
                ->searchable()
                ->formatStateUsing(function ($state, TickettypeAircraft $tickettype_aircraft) {
                    $ticketype_name = Tickettype::find($tickettype_aircraft->tickettype_id);
                    return $ticketype_name->name;
                }),
                Tables\Columns\TextColumn::make('aircraft_id')->label('Légijármű')
                ->searchable()
                ->formatStateUsing(function ($state, TickettypeAircraft $tickettype_aircraft) {
                    $aircraft_name = Aircraft::find($tickettype_aircraft->aircraft_id);
                    return $aircraft_name->name;
                }),
            ])
            ->filters([
                //
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
            'index' => Pages\ListTickettypeAircraft::route('/'),
            'create' => Pages\CreateTickettypeAircraft::route('/create'),
            'edit' => Pages\EditTickettypeAircraft::route('/{record}/edit'),
        ];
    }
}
