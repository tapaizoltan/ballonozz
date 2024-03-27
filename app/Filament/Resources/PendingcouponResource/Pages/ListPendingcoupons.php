<?php

namespace App\Filament\Resources\PendingcouponResource\Pages;

use App\Filament\Resources\PendingcouponResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;

class ListPendingcoupons extends ListRecords
{
    protected static string $resource = PendingcouponResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Mind'),
            'pending' => Tab::make('Jóváhagyásra vár')->query(fn ($query) => $query->where('status', '0'))->icon('tabler-progress-check'),
            'accepted' => Tab::make('Felhasználható')->query(fn ($query) => $query->where('status', '1')->orwhere('status', '2'))->icon('tabler-discount-check'),
        ];
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return 'pending';
    }
}