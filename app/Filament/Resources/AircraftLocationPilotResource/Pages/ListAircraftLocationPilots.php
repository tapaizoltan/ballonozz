<?php

namespace App\Filament\Resources\AircraftLocationPilotResource\Pages;

use App\Filament\Resources\AircraftLocationPilotResource;
use Filament\Actions;
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
}
