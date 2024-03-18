<?php

namespace App\Filament\Resources\TickettypeResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\TickettypeResource;

class ListTickettypes extends ListRecords
{
    protected static string $resource = TickettypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('Mind'),
            'VIP' => Tab::make()->query(fn ($query) => $query->where('vip', '1')),
            'Privát' => Tab::make()->query(fn ($query) => $query->where('private', '1')),
        ];
    }
}
