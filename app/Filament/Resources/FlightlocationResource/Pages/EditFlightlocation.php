<?php

namespace App\Filament\Resources\FlightlocationResource\Pages;

use App\Filament\Resources\FlightlocationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFlightlocation extends EditRecord
{
    protected static string $resource = FlightlocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
