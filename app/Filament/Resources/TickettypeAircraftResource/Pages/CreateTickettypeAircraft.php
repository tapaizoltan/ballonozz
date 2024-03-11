<?php

namespace App\Filament\Resources\TickettypeAircraftResource\Pages;

use App\Filament\Resources\TickettypeAircraftResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTickettypeAircraft extends CreateRecord
{
    protected static string $resource = TickettypeAircraftResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
