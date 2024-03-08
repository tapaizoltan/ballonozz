<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PilotResource\Pages;
use App\Filament\Resources\PilotResource\RelationManagers;
use App\Models\Pilot;
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

class PilotResource extends Resource
{
    protected static ?string $model = Pilot::class;

    protected static ?string $navigationIcon = 'iconoir-user-square';
    protected static ?string $modelLabel = 'pilóta';
    protected static ?string $pluralModelLabel = 'pilóták';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Grid::make(4)
                ->schema([
                    Section::make() 
                    ->schema([
                        Forms\Components\Fieldset::make('Pilóta adatai')
                        ->schema([
                            Forms\Components\TextInput::make('lastname')
                                /*->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Adjon egy fantázianevet a légijárműnek. Érdemes olyan nevet választani, amivel könnyedén azonosítható lesz az adott légijármű.')*/
                                /*->helperText('Adjon egy fantázianevet a helyszínnek. Érdemes olyan nevet választani, amivel könnyedén azonosítható lesz az adott helyszín.')*/
                                ->label('Vezetéknév')
                                ->placeholder('Gipsz'),
                            Forms\Components\TextInput::make('firstname')
                                /*->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Ide a légijármű lajstromjelét adja meg.')*/
                                /*->helperText('Ide a légijármű lajstromjelét adja meg.')*/
                                ->label('Keresztnév')
                                ->placeholder('Jakab'),
                            Forms\Components\TextInput::make('pilot_license_number')
                                /*->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Ide a légijármű lajstromjelét adja meg.')*/
                                /*->helperText('Ide a légijármű lajstromjelét adja meg.')*/
                                ->label('Pilóta engedély azonosító')
                                ->prefixIcon('tabler-id-badge-2')
                                ->placeholder('PPL-SEP'),
                            ])->columns(3),

                        ])->columnSpan(3),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lastname')
                    ->label('Név')
                    ->searchable()
                    ->formatStateUsing(function ($state, Pilot $pilot) {
                        return $pilot->lastname . ' ' . $pilot->firstname;
                    }),
                Tables\Columns\TextColumn::make('pilot_license_number')->label('Pilóta engedély')->searchable(),
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
            'index' => Pages\ListPilots::route('/'),
            'create' => Pages\CreatePilot::route('/create'),
            /*'view' => Pages\ViewPilot::route('/{record}'),*/
            'edit' => Pages\EditPilot::route('/{record}/edit'),
        ];
    }
}
