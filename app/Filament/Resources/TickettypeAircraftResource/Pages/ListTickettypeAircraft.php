<?php

namespace App\Filament\Resources\TickettypeAircraftResource\Pages;

use App\Filament\Resources\TickettypeAircraftResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTickettypeAircraft extends ListRecords
{
    protected static string $resource = TickettypeAircraftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
