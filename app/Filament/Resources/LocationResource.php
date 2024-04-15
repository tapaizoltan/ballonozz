<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Region;
use App\Models\AreaType;
use App\Models\Location;
use Filament\Forms\Form;

use Tables\Columns\Text;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;

/* saját use-ok */
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use App\Filament\Resources\LocationResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LocationResource\RelationManagers;

class LocationResource extends Resource
{
    protected static ?string $model = Location::class;

    protected static ?string $navigationIcon = 'iconoir-strategy';
    protected static ?string $modelLabel = 'helyszín';
    protected static ?string $pluralModelLabel = 'helyszínek';

    protected static ?string $navigationGroup = 'Alapadatok';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(7)
                ->schema([
                    Section::make() 
                    ->schema([
                        TextInput::make('name')
                            /*->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Adjon egy fantázianevet a légijárműnek. Érdemes olyan nevet választani, amivel könnyedén azonosítható lesz az adott légijármű.')*/
                            ->helperText('Adjon egy fantázianevet a helyszínnek. Érdemes olyan nevet választani, amivel könnyedén azonosítható lesz az adott helyszín.')
                            ->label('Elnevezés')
                            ->prefixIcon('tabler-writing-sign')
                            ->placeholder('Békés Airport')
                            ->required()
                            ->minLength(3)
                            ->maxLength(255),
                    ])->columnSpan(2),

                    Section::make() 
                    ->schema([
                        Select::make('region_id')
                            ->label('Régió')
                            ->helperText('Válassza ki vagy a "+" gombra kattintva, hozzon létre egy új régiót, ahova tartozik az adott helyszín.')
                            ->prefixIcon('iconoir-strategy')
                            ->preload()
                            //->options(Region::all()->pluck('name', 'id'))
                            ->relationship(name: 'region', titleAttribute: 'name')
                            ->native(false)
                            ->required()
                            ->searchable()
                            ->createOptionForm([
                                TextInput::make('name')->label('Régió neve')->helperText('Adja meg az új régió nevét. Célszerű olyat választani ami a későbbiekben segítségére lehet a könnyebb azonosítás tekintetében.')
                                    ->required()->unique(),]),
                    ])->columnSpan(2),
                ]),

                Grid::make(7)
                ->schema([
                    Section::make() 
                    ->schema([
                        Fieldset::make('Település')
                        ->schema([
                            TextInput::make('zip_code')
                                /*->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Adjon egy fantázianevet a légijárműnek. Érdemes olyan nevet választani, amivel könnyedén azonosítható lesz az adott légijármű.')*/
                                /*->helperText('Adjon egy fantázianevet a helyszínnek. Érdemes olyan nevet választani, amivel könnyedén azonosítható lesz az adott helyszín.')*/
                                ->label('Irányítószám')
                                ->prefixIcon('tabler-mailbox')
                                ->placeholder('5600'),
                            TextInput::make('settlement')
                                /*->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Ide a légijármű lajstromjelét adja meg.')*/
                                /*->helperText('Ide a légijármű lajstromjelét adja meg.')*/
                                ->label('Település')
                                ->prefixIcon('tabler-building-skyscraper')
                                ->placeholder('Békéscsaba'),
                            ])->columns(3),

                        Fieldset::make('Cím')
                        ->schema([
                            TextInput::make('address')
                                /*->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Ide a légijármű lajstromjelét adja meg.')*/
                                /*->helperText('Ide a légijármű lajstromjelét adja meg.')*/
                                ->label('Cím')
                                ->prefixIcon('tabler-map-pin')
                                ->placeholder('Repülőtér'),
                            Select::make('area_type_id')
                                ->label('Típus')
                                ->prefixIcon('tabler-layout-list')
                                ->options(AreaType::all()->pluck('name', 'id'))
                                ->searchable()
                                ->native(false),
                            TextInput::make('address_number')
                                /*->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Ide a légijármű lajstromjelét adja meg.')*/
                                /*->helperText('Ide a légijármű lajstromjelét adja meg.')*/
                                ->label('Házszám')
                                ->prefixIcon('tabler-number')
                                ->numeric()
                                ->placeholder('13'),
                            ])->columns(3),

                        ])->columnSpan(4),

                    Section::make() 
                    ->schema([
                        Fieldset::make('Helyszín')
                        ->schema([
                            TextInput::make('parcel_number')
                                /*->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Ide a légijármű lajstromjelét adja meg.')*/
                                ->helperText('Amennyiben az adott helyszínnek nincs címe, helyrajzi számmal is rögzítheti azt.')
                                ->label('Helyrajzi szám')
                                ->prefixIcon('tabler-map-route')
                                ->placeholder('0296/8/A'),
                            ])->columns(1)
                    ])->columnSpan(2),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Elnevezés')->searchable()
                    ->description(function ($state, Location $region) {
                        $region_name = Region::find($region->region_id);
                        return $region_name->name;
                    })
                    ,
                TextColumn::make('region.name')
                ->label('Régió'),
                
                TextColumn::make('address')
                    ->label('Cím')
                    ->formatStateUsing(function ($state, Location $location) {
                        $areatype_name = AreaType::find($location->area_type_id);
                        return $location->zip_code . ' ' . $location->settlement . ', '. $location->address . ' ' . $areatype_name->name . ' ' . $location->address_number .'.';
                    })->visibleFrom('md'),
                    TextColumn::make('parcel_number')->label('Helyrajzi szám')->searchable()->visibleFrom('md'),
            ])
            ->filters([
                TrashedFilter::make()->native(false),
            ])
            ->actions([
                /*
                Tables\Actions\ViewAction::make()->hiddenLabel()->tooltip('Megtekintés')->link(),
                Tables\Actions\EditAction::make()->hiddenLabel()->tooltip('Szerkesztés')->link(),
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
            'index' => Pages\ListLocations::route('/'),
            'create' => Pages\CreateLocation::route('/create'),
            /*'view' => Pages\ViewLocation::route('/{record}'),*/
            'edit' => Pages\EditLocation::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationBadge(): ?string //ez kiírja a menü mellé, hogy mennyi helyszín van már rögzítve
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = static::$model;

        return (string) $modelClass::all()->count();
    }

}
