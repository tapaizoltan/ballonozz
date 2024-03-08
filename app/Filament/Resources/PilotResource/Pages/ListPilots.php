<?php

namespace App\Filament\Resources\PilotResource\Pages;

use App\Filament\Resources\PilotResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPilots extends ListRecords
{
    protected static string $resource = PilotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
