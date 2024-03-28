<?php

namespace App\Filament\Resources\AircraftResource\Pages;

use App\Filament\Resources\AircraftResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;

class ListAircraft extends ListRecords
{
    protected static string $resource = AircraftResource::class;

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
            'Hőlégballon' => Tab::make()->query(fn ($query) => $query->where('type', '0'))->icon('iconoir-hot-air-balloon'),
            'Kisrepülőgép' => Tab::make()->query(fn ($query) => $query->where('type', '1'))->icon('iconoir-airplane'),
            'Korlátlan utasszám' => Tab::make()->query(fn ($query) => $query->where('unlimited', '1'))->icon('tabler-infinity'),
            'VIP' => Tab::make()->query(fn ($query) => $query->where('vip', '1'))->icon('tabler-vip'),
            'PRIVATE' => Tab::make()->query(fn ($query) => $query->where('private', '1'))->icon('tabler-crown'),
        ];
    }
}
