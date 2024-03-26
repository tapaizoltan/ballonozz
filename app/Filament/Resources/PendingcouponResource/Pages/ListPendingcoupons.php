<?php

namespace App\Filament\Resources\PendingcouponResource\Pages;

use App\Filament\Resources\PendingcouponResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPendingcoupons extends ListRecords
{
    protected static string $resource = PendingcouponResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
