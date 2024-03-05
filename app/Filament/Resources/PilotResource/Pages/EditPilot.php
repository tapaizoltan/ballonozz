<?php

namespace App\Filament\Resources\PilotResource\Pages;

use App\Filament\Resources\PilotResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPilot extends EditRecord
{
    protected static string $resource = PilotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
