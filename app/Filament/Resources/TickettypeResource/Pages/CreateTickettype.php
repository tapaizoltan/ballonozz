<?php

namespace App\Filament\Resources\TickettypeResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\DB;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\TickettypeResource;

class CreateTickettype extends CreateRecord
{
    protected static string $resource = TickettypeResource::class;

    /*
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if ($data['default'] == 1)
        {
            $aircrafttype = $data['aircrafttype'];

            dd(DB::table('tickettype')
              ->where('deafult', 1)
              ->orwhere('aircrafttype', $aircrafttype)
              ->update(['default' => 0]));
        }
        
        return $data;
    }
    */

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
