<?php

namespace App\Filament\Resources\PendingcouponResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Resources\PendingcouponResource;

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

    protected function getFormActions(): array
    {
        return [
            Actions\Action::make('teszt'),
        ];
    }

    public function saveAnother():void
    {
        $resources = static::getResource();
        $this->save(false);
        $this->redirect($resources::getUrl('create'));
    }

}
