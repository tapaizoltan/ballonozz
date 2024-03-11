<?php

namespace App\Filament\Resources\TickettypeResource\Pages;

use App\Filament\Resources\TickettypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTickettype extends EditRecord
{
    protected static string $resource = TickettypeResource::class;

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
