<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Tickettype;
use Filament\Tables\Table;
use App\Enums\CouponStatus;
use App\Models\Pendingcoupon;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Grouping\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Laravel\SerializableClosure\Serializers\Native;
use App\Filament\Resources\PendingcouponResource\Pages;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use App\Filament\Resources\PendingcouponResource\RelationManagers;

class PendingcouponResource extends Resource
{
    protected static ?string $model = Pendingcoupon::class;

    protected static ?string $navigationIcon = 'tabler-progress-check';
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
                                TextInput::make('coupon_code')
                                    ->label('Kuponkód')
                                    ->prefixIcon('iconoir-password-cursor')
                                    ->placeholder('ABC-'. random_int(100000, 999999))
                                    ->required()
                                    ->minLength(3)
                                    ->maxLength(255)
                                    ->disabledOn('edit'),
                                ])
                                //->columnSpan(2),
                                ->columnSpan([
                                    'sm' => 12,
                                    'md' => 12,
                                    'lg' => 4,
                                    'xl' => 4,
                                    '2xl' => 2,
                                ]),

                        Section::make()
                            ->schema([
                                Fieldset::make('Utasok száma')
                                    ->schema([
                                        TextInput::make('adult')
                                            ->helperText('Adja meg a kuponhoz tartozó felnőtt utasok számát.')
                                            ->label('Felnőtt')
                                            ->prefixIcon('tabler-friends')
                                            ->required()
                                            //->disabledOn('edit')
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
                                            //->disabledOn('edit')
                                            ->numeric()
                                            ->default(0)
                                            ->minLength(1)
                                            ->maxLength(10)
                                            ->suffix(' fő'),
                                    ])->columns(2),
                                ])
                                //->columnSpan(4),
                                ->columnSpan([
                                    'sm' => 12,
                                    'md' => 12,
                                    'lg' => 8,
                                    'xl' => 8,
                                    '2xl' => 4,
                                ]),

                            Section::make()
                                ->schema([
                                    Fieldset::make('Jóváhagyás')
                                        ->schema([
                                            Select::make('tickettype_id')
                                                ->helperText('Válassza ki a kívánt jegytípust.')
                                                ->label('Jegytípus')
                                                ->prefixIcon('heroicon-o-ticket')
                                                ->required()
                                                //->disabledOn('edit')
                                                //->options(Tickettype::all()->pluck('name', 'id'))
                                                ->native(false)
                                                //->relationship('tickettype')
                                                ->relationship(
                                                    name: 'tickettype',
                                                    modifyQueryUsing: fn (Builder $query) => $query->orderBy('aircrafttype')->orderBy('default', 'desc')->orderBy('name'),
                                                )
                                                ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->aircrafttype->getLabel()} - {$record->name}"),
                                            
                                            ToggleButtons::make('status')
                                                ->helperText('Hagyja jóvá vagy utasítsa el ennek a kuponnak a felhasználást.')
                                                ->label('Válassza ki kuponjának forrását')
                                                ->inline()
                                                ->required()
                                                ->default('0')
                                                //->disabledOn('edit')
                                                ->live()
                                                ->options(CouponStatus::class)
                                                /*->options([
                                                    '0' => 'Nem hagyom jóvá',
                                                    '1' => 'Jóváhagyom',
                                                ])
                                                ->icons([
                                                    '0' => 'heroicon-o-hand-thumb-down',
                                                    '1' => 'heroicon-o-hand-thumb-up',
                                                ])
                                                ->colors([
                                                    '0' => 'danger',
                                                    '1' => 'success',
                                                ])
                                                */,
                                            
                                        ])->columns(2),

                                        Fieldset::make('Érvényesség hosszabbítás')
                                        ->schema([
                                            DatePicker::make('expiration_at')
                                                ->label('Felhasználható')
                                                ->helperText('Itt módosíthatja az adott kupon érvényességi idejét.')
                                                ->prefixIcon('tabler-calendar')
                                                ->weekStartsOnMonday()
                                                ->native(false)
                                                ->format('Y-m-d')
                                                ->displayFormat('Y-m-d')
                                                ->default(now()),
                                        ])->columns(2),
                                    ])//->columnSpan(6),
                                    ->columnSpan([
                                        'sm' => 12,
                                        'md' => 12,
                                        'lg' => 12,
                                        'xl' => 12,
                                        '2xl' => 6,
                                    ]),

                        ]),
                    ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        /*
        ->defaultSort('expiration_at', 'desc')
        ->defaultGroup('status')
        ->groups([
            Group::make('status')
                ->label('Státusz')
                ->collapsible(),
        ])
        ->groupingSettingsHidden()
        ->recordClasses(fn (Model $record) => $record->expiration_at < now() ? 'opacity-[50%]' : null)
        */
        /*
        ->recordClasses(fn (Pendingcoupon $record) => match ($record->status) {
            CouponStatus::UnderProcess => 'bg-yellow-300 text-gray-600 dark:bg-yellow-300 daryk:text-gray-600',
            //CouponStatus::CanBeUsed => 'bg-orange dark:bg-orange',
            //CouponStatus::Used => 'bg-green dark:bg-green',
            default => null,
        })
        */
        ->recordClasses(function(Pendingcoupon $record)
        {
            $diff_day_nums = Carbon::parse($record->expiration_at)->diffInDays('now', false);
            if($diff_day_nums > 0 && $diff_day_nums < 31)
            {
                return 'bg-yellow-300 dark:bg-amber-600/30';
            }
            return;
        })
        ->columns([
            TextColumn::make('coupon_code')
                ->label('Kuponkód')
                ->description(fn (Pendingcoupon $record): string => $record->source)
                ->wrap()
                ->color('Amber')
                ->searchable(),
            TextColumn::make('adult')
                ->label('Utasok')
                ->formatStateUsing(function ($state, Pendingcoupon $payload) {
                    return'<p><span class="text-custom-600 dark:text-custom-400" style="font-size:11pt;">'.$payload->adult.'</span><span class="text-gray-500 dark:text-gray-400" style="font-size:9pt;"> felnőtt</span></p><p><span class="text-custom-600 dark:text-custom-400" style="font-size:11pt;">'.$payload->children.'</span><span class="text-gray-500 dark:text-gray-400" style="font-size:9pt;"> gyerek</span></p>';
                })->html()
                ->searchable()
                ->visibleFrom('md'),
            TextColumn::make('expiration_at')
                ->label('Lejárat')
                ->formatStateUsing(function($state)
                {
                    $diff_day_nums = Carbon::parse($state)->diffInDays('now', false);
                    return abs($diff_day_nums).($diff_day_nums < 0 ? ' nap múlva lejár' : ' napja lejárt');
                })
                ->description(function($state)
                {
                    return Carbon::parse($state)->translatedFormat('Y F d');
                })
                ->searchable()
                ->color(function($state)
                {
                    $diff_day_nums = Carbon::parse($state)->diffInDays('now', false);
                    if($diff_day_nums > 0 && $diff_day_nums < 31)
                    {
                        return 'primary';
                    }
                    return;
                })
                ->visibleFrom('md'),
            TextColumn::make('status')
                ->label('Státusz')
                ->badge()
                ->size('md'),
            TextColumn::make('tickettype_id')
                ->label('Jegytípus')
                ->badge()
                //->color('gray')
                ->color(fn ($record) => \Filament\Support\Colors\Color::Hex ($record->tickettype->color))
                ->formatStateUsing(function ($state, Pendingcoupon $tickettype) {
                    $tickettype_name = Tickettype::find($tickettype->tickettype_id);
                    return $tickettype_name->name;
                })
                ->visibleFrom('md'),
        ])
            /*
            ->columns([
                TextColumn::make('coupon_code')
                    ->label('Kuponkód')
                    ->description(fn (Pendingcoupon $record): string => $record->source)
                    ->wrap()
                    ->color('Amber')
                    ->searchable(),
                TextColumn::make('adult')
                    ->label('Utasok')
                    ->formatStateUsing(function ($state, Pendingcoupon $payload) {
                        return'<p><span class="text-custom-600 dark:text-custom-400" style="font-size:11pt;">'.$payload->adult.'</span><span class="text-gray-500 dark:text-gray-400" style="font-size:9pt;"> felnőtt</span></p><p><span class="text-custom-600 dark:text-custom-400" style="font-size:11pt;">'.$payload->children.'</span><span class="text-gray-500 dark:text-gray-400" style="font-size:9pt;"> gyerek</span></p>';
                    })->html()
                    ->searchable()
                    ->visibleFrom('md'),
                TextColumn::make('status')
                    ->label('Státusz')
                    ->badge()
                    ->size('md'),
                TextColumn::make('tickettype_id')
                    ->label('Jegytípus')
                    ->badge()
                    //->color('gray')
                    ->color(fn ($record) => \Filament\Support\Colors\Color::Hex ($record->tickettype->color))
                    ->formatStateUsing(function ($state, Pendingcoupon $tickettype) {
                        $tickettype_name = Tickettype::find($tickettype->tickettype_id);
                        return $tickettype_name->name;
                    })
                    ->visibleFrom('md'),
            ])*/
            ->filters([
                
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')->label('Létrehozási dátumtól')->native(false)->format('Y-m-d')->displayFormat('Y-m-d'),
                        DatePicker::make('created_until')->label('Létrehozási dátumig')->native(false)->format('Y-m-d')->displayFormat('Y-m-d')->default(now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                /*    
                Filter::make('expiration_at')
                    ->form([
                        DatePicker::make('expiration_from')->label('Lejárati dátumtól')->native(false)->format('Y-m-d')->displayFormat('Y-m-d'),
                        DatePicker::make('expiration_until')->label('Lejárati dátumig')->native(false)->format('Y-m-d')->displayFormat('Y-m-d')->default(now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['expiration_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('expiration_at', '>=', $date),
                            )
                            ->when(
                                $data['expiration_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('expiration_at', '<=', $date),
                            );
                    })*/
            ])
            ->actions([
                //Tables\Actions\EditAction::make()->hiddenLabel()->tooltip('Szerkesztés')->link()
                //->hidden(fn ($record) => ($record->status==CouponStatus::Used)),
                Tables\Actions\DeleteAction::make()->label(false)->tooltip('Törlés')
                //->hidden(fn ($record) => ($record->status==CouponStatus::Used)),
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
                        return route('filament.admin.resources.pendingcoupons.edit', ['record' => $record]);
                    }
                },
            )
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    /*
    //ez a scope ami a model-ben deklarálva lett
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->underProcess();
    }
    */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPendingcoupons::route('/'),
            'create' => Pages\CreatePendingcoupon::route('/create'),
            'edit' => Pages\EditPendingcoupon::route('/{record}/edit'),
        ];
    }
}
