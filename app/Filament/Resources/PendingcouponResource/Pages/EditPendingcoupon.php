<?php

namespace App\Filament\Resources\PendingcouponResource\Pages;

use App\Filament\Resources\PendingcouponResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPendingcoupon extends EditRecord
{
    protected static string $resource = PendingcouponResource::class;

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
