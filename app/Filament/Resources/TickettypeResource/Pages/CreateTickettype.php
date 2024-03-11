<?php

namespace App\Filament\Resources\TickettypeResource\Pages;

use App\Filament\Resources\TickettypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTickettype extends CreateRecord
{
    protected static string $resource = TickettypeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
