<?php

namespace App\Filament\Resources\CouponResource\Pages;

use App\Filament\Resources\CouponResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCoupon extends CreateRecord
{
    protected static string $resource = CouponResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
    
        return $data;
    }

    /*
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    */
    protected static bool $canCreateAnother = false;
    

    /*
    protected function getCreateFormAction(): \Filament\Actions\Action
    {
        return parent::getCreateFormAction()
        ->visible(fn (GET $get, $operation) => ($get('source') != 'Egyéb') && $operation == 'create');
    }
    */
    /*
    protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->disabled('true')
            ->hidden();
    }
    */
}