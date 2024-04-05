<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\CouponStatus;
use App\Models\Pendingcoupon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Laravel\SerializableClosure\Serializers\Native;
use App\Filament\Resources\PendingcouponResource\Pages;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use App\Filament\Resources\PendingcouponResource\RelationManagers;
use App\Models\Tickettype;
use Filament\Forms\Components\Select;

class PendingcouponResource extends Resource
{
    protected static ?string $model = Pendingcoupon::class;

    protected static ?string $navigationIcon = 'tabler-progress-check';
    protected static ?string $modelLabel = 'elbírálásra váró kupon';
    protected static ?string $pluralModelLabel = 'elbírálásra váró kuponok';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(12)
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('coupon_code')
                                    ->helperText('Adja meg a már korábban megkapott kuponkódját.')
                                    ->label('Kuponkód')
                                    ->prefixIcon('iconoir-password-cursor')
                                    ->placeholder('ABC-'. random_int(100000, 999999))
                                    ->required()
                                    ->minLength(3)
                                    ->maxLength(255)
                                    ->disabledOn('edit'),
                                ])->columnSpan(2),

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
                                ])->columnSpan(4),

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
                                                ->options(Tickettype::all()->pluck('name', 'id'))
                                                ->native(false),

                                            ToggleButtons::make('status')
                                                ->helperText('Válassza ki honnan származik az adott kupon.')
                                                ->label('Válassza ki kuponjának forrását')
                                                ->inline()
                                                ->required()
                                                ->default('0')
                                                //->disabledOn('edit')
                                                ->live()
                                                ->options([
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
                                                ]),
                                            
                                        ])->columns(2),
                                    ])->columnSpan(5),

                        ]),
                    ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
                    ->searchable(),
                /*    
                TextColumn::make('vip')
                    ->label(false)
                    ->badge()
                    ->width(30)
                    ->size('sm'),
                TextColumn::make('private')
                    ->label(false)
                    ->badge()
                    ->size('sm'),
                */
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->underProcess();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPendingcoupons::route('/'),
            'create' => Pages\CreatePendingcoupon::route('/create'),
            'edit' => Pages\EditPendingcoupon::route('/{record}/edit'),
        ];
    }
}
