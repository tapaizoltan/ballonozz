<?php

namespace App\Filament\Resources\AircraftResource\Pages;

use App\Filament\Resources\AircraftResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;

class ListAircraft extends ListRecords
{
    protected static string $resource = AircraftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('Mind'),
            'Hőlégballon' => Tab::make()->query(fn ($query) => $query->where('type', '0')),
            'Kisrepülőgép' => Tab::make()->query(fn ($query) => $query->where('type', '1')),
        ];
    }
}
