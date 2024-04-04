<?php

namespace App\Filament\Pages;

use App\Models\Coupon;
use App\Models\Aircraft;
use Filament\Pages\Page;
use Livewire\Attributes\Computed;
use App\Models\AircraftLocationPilot;
use App\Models\Checkin as CheckinModel;
use App\Enums\AircraftLocationPilotStatus;

class Checkin extends Page
{
    public $coupons;
    public $coupon_id;
    protected static ?string $title = 'Jelentkezések';
    protected ?string $heading = 'Kuponjaid';
    protected static ?string $navigationLabel = 'Jelentkezések';
    protected static ?string $navigationIcon = 'iconoir-user-badge-check';
    protected static string $view = 'filament.pages.checkin';

    public function mount()
    {
        $this->coupons = Coupon::query()
            ->orderBy('source')
            ->orderBy('coupon_code')
            ->get()
            ->map(function ($coupon) {
                
                if ($coupon->isActive) {
                    return $coupon;
                }

                return null;

            })->whereNotNull();

        if ($this->coupons->count()) {
            $this->coupon_id = $this->coupons->first()->id;
        }
    }

    #[Computed]
    public function coupon()
    {
        if ($this->coupon_id === null) {
            return null;
        }
        
        return $this->coupons->where('id', $this->coupon_id)->first();
    }

    #[Computed]
    public function events()
    {
        if ($this->coupon === null) {
            return false;
        }

        return AircraftLocationPilot::query()

            // TODO Jelenleg csak a mainapra szűrünk,
            // azaz tudunk jelentkezni olyan eseményre ami ma van, de már pl. 1 órája végét ért.
            ->where('date', '>=', now()->format('Y-m-d'))  
        
            ->whereIn('status', [AircraftLocationPilotStatus::Published, AircraftLocationPilotStatus::Finalized])
            ->withWhereHas('aircraft', function ($query) {
                $query->where('number_of_person', '>=', $this->coupon->membersCount);
            })
            ->withWhereHas('aircraft.tickettypes', function ($query) {
                $query->where('id', $this->coupon->tickettype->id);
            })
            ->orderBy('date')
            ->orderBy('time')
            ->get();
    }

    public function checkIn($aircraftLocationPilotId)
    {
        CheckinModel::create([
            'aircraft_location_pilot_id' => $aircraftLocationPilotId,
            'coupon_id'  => $this->coupon->id,
            'status'     => 0,
            'created_at' => now()->format('Y-m-d H:i:s')
        ]);
    }

    public function checkOut($aircraftLocationPilotId)
    {
        CheckinModel::where('aircraft_location_pilot_id', $aircraftLocationPilotId)
            ->where('coupon_id', $this->coupon->id)
            ->delete();
    }
}
