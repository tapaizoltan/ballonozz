<?php

namespace App\Filament\Resources\TickettypeResource\Pages;

use Filament\Actions;
use App\Models\Tickettype;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\TickettypeResource;

class EditTickettype extends EditRecord
{
    protected static string $resource = TickettypeResource::class;

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

    /*
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $before_modified_default_value = $data['default'];
        if ($before_modified_default_value == 1)
        {
            $before_modified_default_value = true;
        }
        if ($before_modified_default_value == 0)
        {
            $before_modified_default_value = false;
        }
    }
    */

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $aircrafttype = $data['aircrafttype'];

        if ($data['default'] == 0)
        {
            $aircrafttype_deafaut_tickettype_check = Tickettype::where('aircrafttype', $aircrafttype)->where('default', 1)->get()->count();
            if ($aircrafttype_deafaut_tickettype_check == 0)
            {
                $data['default'] = 1;
            }
        }

        $aircrafttype_deafaut_tickettype_check = Tickettype::where('aircrafttype', $aircrafttype)->where('default', 1)->get()->count();
        if ($aircrafttype_deafaut_tickettype_check == 0)
        {
            $data['default'] = 1;
        }
        if ($aircrafttype_deafaut_tickettype_check != 0)
        {
            //megkeresni, hogy melyik a default, abban módosítani 0-ra és ebben felülírni 1-re  
        }

        return $data;
    }

    /*
    protected function beforeSave(): void
    {
        //dd($this->data);
        
        $aircrafttype = $this->data['aircrafttype'];
        $default = $this->data['default'];
        
        //itt leelenőrizzük, hogy ven-e már olyan jegytípus ami az adott légijármű típushoz tartozik.
        $tickettype_numbers = Tickettype::where('aircrafttype', $aircrafttype)->count();
        if ($tickettype_numbers == 0)
        {
            //itt leelenőrizzük, hogy az adott légijármű típusban van-e már egy jegytípus is a rendszerben.
            //...na nincs akkor az elsőhöz mindenkép hozzáadjuk úgy, hogy ő a default jegytípus az adott légijármű típusban.
        }

        if ($tickettype_numbers >= 1)
        {
            // ez hatódik végre, ha az adott légijármű típushoz már val legalább egy jegytípus társítva
            $default_tickettype_number_in_aircrafttype = Tickettype::where('aircrafttype', $aircrafttype)->where('default', $default)->get()->count();
            
            if ($default_tickettype_number_in_aircrafttype == 0)
            {
                //engedélyezzük az alapértelmezettség bekapcsolásának lehetőségét
            }
            if ($default_tickettype_number_in_aircrafttype == 1)
            {
                //letiltjuk az alapértelmezettség bekapcsolásának lehetőségét
            }
        }


        //dd($checking_default = Tickettype::where('aircrafttype', $aircrafttype)->where('default', $default)->get()->count());
        
        Tickettype::where('active', 1)
        ->where('destination', 'San Diego')
        ->update(['delayed' => 1]);
        
    }
    */
}
