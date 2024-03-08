<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Location;
use Filament\Forms\Form;
use Tables\Columns\Text;
use Filament\Tables\Table;

use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\LocationResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LocationResource\RelationManagers;

/* saját use-ok */
use App\Models\AreaType;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;

class LocationResource extends Resource
{
    protected static ?string $model = Location::class;

    protected static ?string $navigationIcon = 'iconoir-strategy';
    protected static ?string $modelLabel = 'helyszín';
    protected static ?string $pluralModelLabel = 'helyszínek';


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
                            ->helperText('Adjon egy fantázianevet a helyszínnek. Érdemes olyan nevet választani, amivel könnyedén azonosítható lesz az adott helyszín.')
                            ->label('Elnevezés')
                            ->prefixIcon('tabler-writing-sign')
                            ->placeholder('Békés Airport')
                            ->required()
                            ->minLength(3)
                            ->maxLength(255),
                    ])->columnSpan(2),
                ]),

                Grid::make(4)
                ->schema([
                    Section::make() 
                    ->schema([
                        Forms\Components\Fieldset::make('Település')
                        ->schema([
                            Forms\Components\TextInput::make('zip_code')
                                /*->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Adjon egy fantázianevet a légijárműnek. Érdemes olyan nevet választani, amivel könnyedén azonosítható lesz az adott légijármű.')*/
                                /*->helperText('Adjon egy fantázianevet a helyszínnek. Érdemes olyan nevet választani, amivel könnyedén azonosítható lesz az adott helyszín.')*/
                                ->label('Irányítószám')
                                ->prefixIcon('tabler-mailbox')
                                ->placeholder('5600'),
                            Forms\Components\TextInput::make('settlement')
                                /*->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Ide a légijármű lajstromjelét adja meg.')*/
                                /*->helperText('Ide a légijármű lajstromjelét adja meg.')*/
                                ->label('Település')
                                ->prefixIcon('tabler-building-skyscraper')
                                ->placeholder('Békéscsaba'),
                            ])->columns(2),

                        Forms\Components\Fieldset::make('Cím')
                        ->schema([
                            Forms\Components\TextInput::make('address')
                                /*->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Ide a légijármű lajstromjelét adja meg.')*/
                                /*->helperText('Ide a légijármű lajstromjelét adja meg.')*/
                                ->label('Cím')
                                ->prefixIcon('tabler-map-pin')
                                ->placeholder('Repülőtér'),
                            Forms\Components\Select::make('area_type_id')
                                ->label('Típus')
                                ->prefixIcon('tabler-layout-list')
                                ->options(AreaType::all()->pluck('name', 'id')),
                            Forms\Components\TextInput::make('address_number')
                                /*->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Ide a légijármű lajstromjelét adja meg.')*/
                                /*->helperText('Ide a légijármű lajstromjelét adja meg.')*/
                                ->label('Házszám')
                                ->prefixIcon('tabler-number')
                                ->placeholder('13'),
                            ])->columns(3),

                        ])->columnSpan(3),

                    Section::make() 
                    ->schema([
                        Forms\Components\Fieldset::make('Helyszín')
                        ->schema([
                            Forms\Components\TextInput::make('parcel_number')
                                /*->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Ide a légijármű lajstromjelét adja meg.')*/
                                ->helperText('Amennyiben az adott helyszínnek nincs címe, helyrajzi számmal is rögzítheti azt.')
                                ->label('Helyrajzi szám')
                                ->prefixIcon('tabler-map-route')
                                ->placeholder('0296/8/A'),
                            ])->columns(1)
                    ])->columnSpan(1),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Elnevezés')->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('Cím')
                    ->formatStateUsing(function ($state, Location $location) {
                        $areatype_name = AreaType::find($location->area_type_id);
                        return $location->zip_code . ' ' . $location->settlement . ', '. $location->address . ' ' . $areatype_name->name . ' ' . $location->address_number .'.';
                    }),
                    Tables\Columns\TextColumn::make('parcel_number')->label('Helyrajzi szám')->searchable(),
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
            'index' => Pages\ListLocations::route('/'),
            'create' => Pages\CreateLocation::route('/create'),
            /*'view' => Pages\ViewLocation::route('/{record}'),*/
            'edit' => Pages\EditLocation::route('/{record}/edit'),
        ];
    }
}
