<?php

namespace App\Filament\Pages;

use App\Enums\AircraftLocationPilotStatus;
use App\Models\AircraftLocationPilot;
use App\Models\Coupon;
use App\Models\Checkin as CheckinModel;
use Filament\Pages\Page;
use Livewire\Attributes\Computed;

class Checkin extends Page
{
    public $coupons;
    public $coupon_id;
    protected static ?string $title = 'Kuponjaid';
    protected static ?string $navigationLabel = 'Jelentkezések';
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
    public function coupon()
    {
        if ($this->coupon_id === null) {
            return null;
        }
        
        return $this->coupons->find($this->coupon_id);
    }

    #[Computed]
    public function dates()
    {
        if ($this->coupon === null) {
            return false;
        }

        return AircraftLocationPilot::query()
                ->whereIn('status', [AircraftLocationPilotStatus::Published, AircraftLocationPilotStatus::Finalized])
                ->whereIn('aircraft_id', $this->coupon->ticketType->aircrafts->pluck('id')->toArray())
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
