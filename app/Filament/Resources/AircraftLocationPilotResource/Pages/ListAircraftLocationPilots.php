<?php

namespace App\Filament\Resources\AircraftLocationPilotResource\Pages;

use App\Filament\Resources\AircraftLocationPilotResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListAircraftLocationPilots extends ListRecords
{
    protected static string $resource = AircraftLocationPilotResource::class;

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
            'Tervezett' => Tab::make()->query(fn ($query) => $query->where('status', '0')),
            'Publikált' => Tab::make()->query(fn ($query) => $query->where('status', '1')),
            'Végrehajtott' => Tab::make()->query(fn ($query) => $query->where('status', '2')),
            'Törölt' => Tab::make()->query(fn ($query) => $query->where('status', '3')),
        ];
    }
}
