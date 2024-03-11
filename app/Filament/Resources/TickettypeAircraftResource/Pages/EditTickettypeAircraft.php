<?php

namespace App\Filament\Resources\TickettypeAircraftResource\Pages;

use App\Filament\Resources\TickettypeAircraftResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTickettypeAircraft extends EditRecord
{
    protected static string $resource = TickettypeAircraftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
