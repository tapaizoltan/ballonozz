<?php

namespace App\Filament\Resources\FlightlocationResource\Pages;

use App\Filament\Resources\FlightlocationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFlightlocations extends ListRecords
{
    protected static string $resource = FlightlocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }
}
