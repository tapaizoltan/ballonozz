<?php

namespace App\Filament\Pages;

use App\Enums\AircraftLocationPilotStatus;
use App\Models\AircraftLocationPilot;
use App\Models\Coupon;
use Filament\Pages\Page;
use Livewire\Attributes\Computed;

class Checkin extends Page
{
    public $coupons;
    public $coupon_id;
    protected static ?string $title = 'Jelentkezések Page';
    protected static ?string $navigationIcon = 'iconoir-user-badge-check';
    protected static string $view = 'filament.pages.checkin';

    public function mount()
    {
        $this->coupons = Coupon::query()->with('ticketType.aircrafts')->orderBy('source')->orderBy('coupon_code')->get();
        if ($this->coupons->count()) {
            $this->coupon_id = $this->coupons->first()->id;
        }
    }

    #[Computed]
    public function dates()
    {
        if(!$this->coupon_id) {
            return false;
        }

        return  AircraftLocationPilot::query()
                    ->where('status', AircraftLocationPilotStatus::Published)
                    ->whereIn('aircraft_id', $this->coupon->ticketType->aircrafts->pluck('id')->toArray())
                    ->get();
    }

    #[Computed]
    public function coupon()
    {
        if ($this->coupon_id === null) {
            return null;
        }
        
        return $this->coupons->find($this->coupon_id);
    }

    
}
