<?php

namespace App\Filament\Resources;
use Closure;
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
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use App\Models\CouponCodeAttempt;
use Filament\Actions\CreateAction;
use Illuminate\Support\Facades\DB;
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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(12)
                    ->schema([
                        Section::make()
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
                                        ])->columnSpan(4),
                                    Section::make()
                                        ->schema([

                                            ToggleButtons::make('source')
                                                ->helperText('Válassza ki honnan származik az adott kupon.')
                                                ->label('Válassza ki kuponjának forrását')
                                                ->inline()
                                                ->required()
                                                ->default('Ballonozz')
                                                ->disabledOn('edit')
                                                ->live()
                                                ->options([
                                                    //'Meglepkék' => 'Meglepkék',
                                                    'Ballonozz' => 'Ballonozz.hu',
                                                    'Egyéb' => 'Egyéb',
                                                ])
                                                ->icons([
                                                    //'Meglepkék' => 'tabler-butterfly',
                                                    'Ballonozz' => 'iconoir-hot-air-balloon',
                                                    'Egyéb' => 'tabler-progress-help',
                                                ])
                                                ->colors([
                                                    //'Meglepkék' => 'info',
                                                    'Ballonozz' => 'info',
                                                    'Egyéb' => 'info',
                                                ]),
                                                /*
                                                Actions::make([Forms\Components\Actions\Action::make('Ellenőrzés')
                                                ->action(
                                                        function($livewire)
                                                        {
                                                            $data = $livewire->form->getState();
                                                            $checkable_coupon_code = $data['coupon_code'];
                                                            if (!empty($checkable_coupon_code))
                                                            {
                                                                $finding_match = Coupon::where('coupon_code', $checkable_coupon_code)->first();
                                                                if (!empty($finding_match))
                                                                {
                                                                    //Ez fut le ha már van ilyen kupon a táblában
                                                                }
                                                                if (empty($finding_match))
                                                                {
                                                                    $response_coupon = Http::withBasicAuth(env('BALLONOZZ_API_USER_KEY'), env('BALLONOZZ_API_SECRET_KEY'))->get('https://ballonozz.hu/wp-json/wc/v3/orders/'.$checkable_coupon_code);
                                                                    //Felőtt(3db->3f): 1567 
                                                                    //Családi(1db->2f+2gy): 1508
                                                                    if ($response_coupon->successful())
                                                                    {
                                                                        $coupons_data = $response_coupon->json();
                                                                        dd($payment_status = ($coupons_data['status']));
                                                                        foreach($coupons_data['line_items'] as $coupon)
                                                                        {
                                                                            $response_item_nums = $coupon['quantity']; 
                                                                            $response_product_id = $coupon['product_id'];
                                                                            
                                                                            $response_product_attributes = Http::withBasicAuth(env('BALLONOZZ_API_USER_KEY'), env('BALLONOZZ_API_SECRET_KEY'))->get('https://ballonozz.hu/wp-json/wc/v3/products/'.$response_product_id);
                                                                            if ($response_product_attributes->successful())
                                                                            {
                                                                                $product_attributes = $response_product_attributes->json();
                                                                                $tickettype = ($product_attributes['attributes'][0]['options'][0])*1;
                                                                                $adult = ($product_attributes['attributes'][1]['options'][0])*$response_item_nums;
                                                                                $children = ($product_attributes['attributes'][2]['options'][0])*$response_item_nums;
        
                                                                                $new_coupon = Coupon::create([
                                                                                    'user_id' => Auth::id(),
                                                                                    'coupon_code' => $checkable_coupon_code,
                                                                                    'source' => 'Ballonozz',
                                                                                    'adult' => $adult,
                                                                                    'children' => $children,
                                                                                    'tickettype_id' => $tickettype,
                                                                                    'status' => CouponStatus::CanBeUsed,
                                                                                ]);
        
                                                                                return redirect()->route('filament.admin.resources.coupons.edit', ['record' => $new_coupon]);
        
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    )
                                                    ])
                                                    ->hidden(fn (GET $get, $operation): bool => ($get('source')=='Egyéb' || $operation=='edit')),*/

                                            /*
                                            Actions::make([Forms\Components\Actions\Action::make('Létrehozás')
                                                    //->hiddenOn('edit')
                                                    ->extraAttributes(['type'=>'submit'])
                                                    ->action(
                                                        function(Get $get, $livewire)
                                                        {
                                                            $data = $livewire->form->getState();
                                                            dd($data);
                                                            $checkable_coupon_code = $get('coupon_code');
                                                            $adult = $get('adult');
                                                            $children = $get('children');
                                                            if (!empty($checkable_coupon_code) && !empty($adult))
                                                            {
                                                                $new_coupon = Coupon::create([
                                                                'user_id' => Auth::id(),
                                                                'coupon_code' => $checkable_coupon_code,
                                                                'source' => 'Egyéb',
                                                                'adult' => $adult,
                                                                'children' => $children,
                                                                'tickettype_id' => NULL,
                                                                'status' => CouponStatus::UnderProcess,
                                                                ]);
                                                                return redirect()->route('filament.admin.resources.coupons.edit', ['record' => $new_coupon]);
                                                            }                                   
                                                        })
                                                    ])
                                                    ->hidden(fn (GET $get, $operation): bool => ($get('source')!='Egyéb' || $operation=='edit')),
                                                    */
                                        ])->columnSpan(8),
                                    ]),

                            ])->columnSpan(6),

                        Section::make()
                            ->hidden(fn (GET $get, $operation): bool => ($get('source')!='Egyéb' && $operation=='create'))
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
                                            ->disabledOn('edit')
                                            ->numeric()
                                            ->default(0)
                                            ->minLength(1)
                                            ->maxLength(10)
                                            ->suffix(' fő'),
                                    ])->columns(2),
                                /*
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
                                    */
                            ])->columnSpan(4),
                        //Hidden::make('status')->default('0'),
                    ]),
                    
                Grid::make(12)
                    //->hiddenOn('create')
                    ->visible(fn (GET $get, $operation) => (($get('adult') + $get('children')) > 0) && $operation == 'edit')
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
                            ])->columnSpan(12),
                        ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            /*->heading('Clients')->description('ez egy teszt')
            ->striped()*/
            ->recordClasses(fn (Model $record) => $record->expiration_at < now() ? 'bg-lime-700' : null)
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
                        return'<p><span class="text-custom-600 dark:text-custom-400" style="font-size:11pt;">'.$payload->adult.'</span><span class="text-gray-500 dark:text-gray-400" style="font-size:9pt;"> felnőtt</span></p><p><span class="text-custom-600 dark:text-custom-400" style="font-size:11pt;">'.$payload->children.'</span><span class="text-gray-500 dark:text-gray-400" style="font-size:9pt;"> gyerek</span></p>';
                    })->html()
                    ->searchable()
                    ->visibleFrom('md'),
                TextColumn::make('expiration_at')
                    ->label('Felhasználható')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Státusz')
                    ->badge()
                    ->size('md'),
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\ViewAction::make()->hiddenLabel()->tooltip('Megtekintés')->link()
                //->hidden(fn ($record) => ($record->status==CouponStatus::Used)),
                //Tables\Actions\EditAction::make()->hiddenLabel()->tooltip('Szerkesztés')->link()
                //->hidden(fn ($record) => ($record->status==CouponStatus::Used)),
                Tables\Actions\DeleteAction::make()->label(false)->tooltip('Törlés')
                ->hidden(fn ($record) => ($record->status==CouponStatus::Used)),
            ])
            ->headerActions([
                /*
                \Filament\Actions\Action::getCreateFormAction()
                    ->visible(fn (GET $get, $operation) => ($get('source') == 'Egyéb') && $operation == 'create'),*/
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
