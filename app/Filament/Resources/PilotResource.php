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

class PilotResource extends Resource
{
    protected static ?string $model = Pilot::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $modelLabel = 'pilóta';
    protected static ?string $pluralModelLabel = 'pilóták';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPilots::route('/'),
            'create' => Pages\CreatePilot::route('/create'),
            'edit' => Pages\EditPilot::route('/{record}/edit'),
        ];
    }
}
