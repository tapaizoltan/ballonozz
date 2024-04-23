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
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\Layout\Stack;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Forms\Components\Actions\Action;
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
                Grid::make(12)
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
                    ])->columnSpan([
                        'sm' => 6,
                        'md' => 6,
                        'lg' => 6,
                        'xl' => 6,
                        '2xl' => 4,
                    ]),

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
                    ])->columnSpan([
                        'sm' => 6,
                        'md' => 6,
                        'lg' => 6,
                        'xl' => 6,
                        '2xl' => 4,
                    ]),
                ]),

                Grid::make(12)
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
                            ])->columns([
                                'sm' => 1,
                                'md' => 2,
                                'lg' => 2,
                                'xl' => 3,
                                '2xl' => 3,
                                ]),

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
                            ])->columns([
                                'sm' => 1,
                                'md' => 2,
                                'lg' => 2,
                                'xl' => 2,
                                '2xl' => 3,
                                ]),

                        ])->columnSpan([
                            'sm' => 6,
                            'md' => 6,
                            'lg' => 7,
                            'xl' => 8,
                            '2xl' => 7,
                        ]),

                    Section::make() 
                    ->schema([
                        Fieldset::make('Helyszín')
                        ->schema([
                            TextInput::make('coordinates')
                            ->helperText('Megadhatja a helyszín szélességi és hosszúsági koordinátáit.')
                            ->label('Koordináták')
                            ->prefixIcon('tabler-compass')
                            ->placeholder('47.6458345, 19.9761906'),
                            TextInput::make('online_map_link')
                            ->helperText('Megadhat térkép linket a könnyebb útvonaltervezés céljából.')
                            ->label('Online térkép link')
                            ->prefixIcon('tabler-map-route')
                            ->placeholder('https://www.google.com/maps/@47.6458345,19.9761906,19.5z?entry=ttu')
                            ->live()
                            ->suffixAction(
                                Action::make('redirect')
                                    ->icon('tabler-arrow-loop-right')
                                    ->tooltip('Ide kattintva megnézhet egy új ablakban a behelyezett linket.')
                                    ->url(function($state){return $state;})
                                    ->openUrlInNewTab(),
                            ),
                            FileUpload::make('image_path')
                            ->label('Kép feltöltése')
                            ->helperText('Feltölthet fényképet a helyszínről, hogy az könnyebben beazonosítható legyen.')
                            ->directory('form-attachments')
                            ->image()
                            ->maxSize(10000),
                            ])->columns([
                                'sm' => 2,
                                'md' => 2,
                                'lg' => 1,
                                'xl' => 1,
                                '2xl' => 1,
                                ]),
                    ])->columnSpan([
                        'sm' => 6,
                        'md' => 6,
                        'lg' => 5,
                        'xl' => 4,
                        '2xl' => 5,
                    ]),
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
                }),
                TextColumn::make('region.name')
                ->label('Régió'),
                
                TextColumn::make('address')
                ->label('Cím')
                ->formatStateUsing(function ($state, Location $location) {
                    $areatype_name = AreaType::find($location->area_type_id);
                    return $location->zip_code . ' ' . $location->settlement . ', '. $location->address . ' ' . $areatype_name->name . ' ' . $location->address_number .'.';
                })->visibleFrom('md'),
                
                TextColumn::make('coordinates')
                ->label('Navigáció')
                ->icon('tabler-compass'),
                TextColumn::make('online_map_link')
                ->icon('tabler-map-route')
                ->formatStateUsing(function($state)
                {
                    $wrapText='...';
                    $count = 40;
                    if(strlen($state)>$count){
                        preg_match('/^.{0,' . $count . '}(?:.*?)\b/siu', $state, $matches);
                        $text = $matches[0];
                    }else{
                        $wrapText = '';
                    }
                    return $text . $wrapText;
                }),
                ImageColumn::make('image_path')
                ->label('Kép')
                ->square(),
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
                Tables\Actions\RestoreAction::make()->label(false)->tooltip('Helyreállítás'),
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
