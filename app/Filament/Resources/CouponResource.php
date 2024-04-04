<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Faker\Core\Color;
use App\Models\Coupon;
use Faker\Core\Number;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Passenger;
use App\Models\Tickettype;
use Filament\Tables\Table;
use App\Enums\CouponStatus;
use Illuminate\Support\Str;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use App\Models\CouponCodeAttempt;
use Filament\Actions\CreateAction;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Resources\CouponResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CouponResource\RelationManagers;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $modelLabel = 'kupon';
    protected static ?string $pluralModelLabel = 'kuponok';

    /*
    public static function canCreate(): bool
    {
       return false;
    }
    */
    
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
                                    ->maxLength(255)
                                    ->disabledOn('edit'),

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
                                            ->live()
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
                                
                                    Actions::make([Forms\Components\Actions\Action::make('Ellenőrzés')
                                    ->action(
                                        function(Get $get)
                                        {
                                            $checkable_coupon_code = $get('coupon_code');
                                            $finding_match = Coupon::where('coupon_code', $checkable_coupon_code)->first();
                                            if (!empty($finding_match))
                                            {
                                                //Ez fut le ha már van ilyen kupon a táblában
                                            }
                                            if (empty($finding_match))
                                            {
                                                /*
                                                if (count(auth()->user()->attempts) === env('MAX_COUPON_CODE_ATTEMPTS', 5)) {
                                                    Auth::user()->delete();                                              
                                                }
                                                CouponCodeAttempt::create(['user_id' => Auth::id()]);
                                                */
                                                //Ez fut le ha még nincs ilyen kupon a táblában, innen mehet az api lekérdezés
                                                $response_order = Http::withBasicAuth(env('BALLONOZZ_API_USER_KEY'), env('BALLONOZZ_API_SECRET_KEY'))->get('https://ballonozz.hu/wp-json/wc/v3/orders/'.$checkable_coupon_code);
                                                
                                                if ($response_order->successful())
                                                {
                                                    $res = $response_order->json();
                                                    foreach($res['line_items'] as $item) {
                                                        //dump($item['product_id'], $item['quantity']);
                                                        $product_id = $item['product_id'];

                                                        $response_orders_atributes = Http::withBasicAuth(env('BALLONOZZ_API_USER_KEY'), env('BALLONOZZ_API_SECRET_KEY'))->get('https://ballonozz.hu/wp-json/wc/v3/products/'.$product_id);

                                                    }
                                                    return;
                                                    //dd($response_order->json()['line_items'][0]['product_id']);
                                                }
                                            }
                                        }
                                    )
                                    ])
                                    ->hiddenOn('edit')
                                    ->hidden(fn (GET $get): bool => ($get('source')=='Egyéb')),

                                    Actions::make([Action::make('Létrehozás')
                                     ])
                                        ->hiddenOn('edit')
                                        ->hidden(fn (GET $get): bool => ($get('source')!='Egyéb')),
                            
                            ])->columnSpan(4),

                        Section::make()
                            ->hidden(fn (GET $get): bool => ($get('source')!='Egyéb'))                
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
                        //Hidden::make('status')->default('0'),
                    ]),
                    
                Grid::make(12)
                    ->hiddenOn('create')
                    ->hidden(fn (GET $get) => ($get('status')!='1') && ($get('status')!='2'))
                    ->schema([
                        Section::make()
                        ->schema([
                            Repeater::make('passengers')
                                ->addActionLabel('Új utas felvétele')
                                ->label('Utasok')
                                ->relationship()
                                ->maxItems(fn (Get $get) => $get('adult')+$get('children'))
                                ->schema([
                                    Fieldset::make('Kötelező utasadatok')
                                    ->schema([
                                        TextInput::make('lastname')
                                            ->disabledOn('create')
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

                                    Fieldset::make('Opcionális utasadatok')
                                    ->schema([
                                        Placeholder::make('created')
                                        ->label('')
                                        ->content('Kérem adja meg elérhetőségeit, az esetleges, fontos kapcsolatfelvétel céljából. Az itt megadott adatait csak és kizárólag fontos, eseménybeni változásokkor használjuk.'),
                                        TextInput::make('email')
                                            ->email()
                                            ->label('Email cím')
                                            ->prefixIcon('tabler-mail-forward')
                                            ->placeholder('utas@repulnifogok.hu')
                                            ->maxLength(255),
                                        TextInput::make('phone')
                                            ->tel()
                                            ->label('Telefonszám')
                                            ->prefixIcon('tabler-device-mobile')
                                            ->placeholder('+36 __ ___ ____')
                                            ->mask('+36 99 999 9999')
                                            ->maxLength(30)
                                    ])->columns(3),
                                ])->columns(5),
                            ]),
                        ])->columnSpan(12),
                    ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            /*->heading('Clients')->description('ez egy teszt')
            ->striped()*/
            ->columns([
                IconColumn::make('missing_data')
                    ->label('')
                    ->width(0)
                    ->boolean()
                    ->trueIcon('tabler-alert-triangle')
                    ->size(IconColumn\IconColumnSize::Medium)
                    ->trueColor('danger')
                    ->falseIcon('')
                    ->tooltip(fn($state) => $state ? 'Hiányzó utasadatok!':''),
                TextColumn::make('coupon_code')
                    ->label('Kuponkód')
                    ->description(fn (Coupon $record): string => $record->source)
                    ->wrap()
                    ->color('Amber')
                    ->searchable(),
                TextColumn::make('adult')
                    ->label('Utasok')
                    ->formatStateUsing(function ($state, Coupon $payload) {
                        return '<p style="color:gray; font-size:9pt;"><b style="font-size:11pt; font-weight:normal;">' . $payload->adult . '</b> felnőtt</p><p style="color:gray; font-size:9pt;"><b style="color:white; font-size:11pt; font-weight:normal;">' . $payload->children . '</b> gyerek</p>';
                    })->html()
                    ->searchable(),
                TextColumn::make('vip')
                    ->label(false)
                    ->badge()
                    ->width(30)
                    ->size('sm'),
                TextColumn::make('private')
                    ->label(false)
                    ->badge()
                    ->size('sm'),
                TextColumn::make('status')
                    ->label('Státusz')
                    ->badge()
                    ->size('md'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->hiddenLabel()->tooltip('Megtekintés')->link()
                ->hidden(fn ($record) => ($record->status==CouponStatus::Used)),
                Tables\Actions\EditAction::make()->hiddenLabel()->tooltip('Szerkesztés')->link()
                ->hidden(fn ($record) => ($record->status==CouponStatus::Used)),
                Tables\Actions\DeleteAction::make()->label(false)->tooltip('Törlés')
                ->hidden(fn ($record) => ($record->status==CouponStatus::Used)),
            ])
            ->headerActions([

            ])
            ->recordUrl(
                /* így is lehet
                fn (Coupon $record): string => ($record->status==CouponStatus::Used) ?false: route('filament.admin.resources.coupons.edit', ['record' => $record]),
                vagy úgy ahogy ez alatt van */
                function($record)
                {
                    if ($record->status == CouponStatus::Used)
                    {
                        return false;
                    }
                    else
                    {
                        return route('filament.admin.resources.coupons.edit', ['record' => $record]);
                    }
                },
            )
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

        return (string) $modelClass::where('status', '1')->orwhere('status', '2')->count(); 
    }
}
