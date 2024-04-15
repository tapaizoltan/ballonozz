<?php

namespace App\Filament\Resources\AircraftLocationPilotResource\Pages;

use App\Enums\AircraftLocationPilotStatus;
use App\Filament\Resources\AircraftLocationPilotResource;
use App\Models\AircraftLocationPilot;
use Carbon\Carbon;
use Filament\Resources\Pages\Page;
use Illuminate\Support\HtmlString;

class Calendar extends Page
{
    protected static string $resource = AircraftLocationPilotResource::class;
    protected static ?string $title = 'Naptár Nézet';
    protected static string $view = 'filament.resources.aircraft-location-pilot-resource.pages.calendar';

    public $events;

    public function mount()
    {
        $events = AircraftLocationPilot::all();
        foreach ($events as $event) {
            switch ($event->status) {
                case AircraftLocationPilotStatus::Draft:
                    $color = 'rgb(217, 119, 6)';
                    break;

                case AircraftLocationPilotStatus::Finalized:
                    $color = 'rgb(22, 163, 74)';
                    break;
                    
                    case AircraftLocationPilotStatus::Executed:
                    $color = '#71717a';
                    break;

                case AircraftLocationPilotStatus::Deleted:
                    $color = 'rgb(220, 38, 38)';
                    break;
                
                default:
                    $color = 'rgb(37, 99, 235)';
                    break;
            }
            
            $signed     = array_sum($event->coupons->map(fn ($coupon) => $coupon->membersCount)->toArray());
            $classified = array_sum($event->coupons->map(function ($coupon) {
                if ($coupon->pivot->status == 1) {
                    return $coupon->membersCount;
                }
                return 0;
            })->toArray());   

            $this->events[] = [
                'title' => $event->region->name . ' '  . $classified . '/' . $signed,
                'start' => Carbon::parse($event->date . ' ' . $event->time)->format('Y-m-d H:i:s'),
                'end'   => Carbon::parse($event->date . ' ' . $event->time)->addHours($event->period_of_time)->format('Y-m-d H:i:s'),
                'description' => '<div>Státusz: <span style="color: ' . $color . '">' . __($event->status->name) . '</span></div><div>Pilóta: ' . $event->pilot->full_name . '</div>',
                'color' => $color
            ];
        }
        $this->events = json_encode($this->events, true);
    }
}
