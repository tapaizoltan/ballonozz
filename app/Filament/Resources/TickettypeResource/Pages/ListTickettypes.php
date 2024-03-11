<?php

namespace App\Filament\Resources\TickettypeResource\Pages;

use App\Filament\Resources\TickettypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTickettypes extends ListRecords
{
    protected static string $resource = TickettypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
