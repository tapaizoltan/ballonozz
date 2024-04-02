<?php

namespace App\Filament\Resources\AircraftLocationPilotResource\Pages;

use App\Enums\AircraftLocationPilotStatus;
use App\Models\Coupon;
use App\Models\Checkin;
use Filament\Actions\Action;
use Livewire\Attributes\Computed;
use Filament\Resources\Pages\Page;
use App\Models\AircraftLocationPilot;
use Filament\Notifications\Notification;
use App\Filament\Resources\AircraftLocationPilotResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;

class ListCheckins extends Page
{
    use InteractsWithRecord;
    protected static string $resource = AircraftLocationPilotResource::class;
    protected static string $view = 'filament.resources.aircraft-location-pilot-resource.pages.list-checkins';
    public $selectedCoupons = [];
    public $alreadyCheckedCoupons;
    
    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
           
        $this->record->coupons()
            ->wherePivot('status', 1)
            ->get()
            ->map(fn ($coupon) => $this->selectedCoupons[] = $coupon->id);
    
        $this->alreadyCheckedCoupons = array_filter(Coupon::with('aircraftLocationPilots')->withoutGlobalScopes()->get()->map(function ($coupon) {
            if (count($coupon->aircraftLocationPilots->where('pivot.aircraft_location_pilot_id', '!=', $this->record->id)->where('pivot.status', 1))) {
                return $coupon->id;
            }
            // TODO: használat/tervezett attributum a kuponon
        })->toArray());
    }

    public function save()
    {
        $deselectedCoupons = $this->record->coupons()->wherePivotNotIn('coupon_id', $this->selectedCoupons)->pluck('coupon_id')->toArray();
        $this->record->coupons()->updateExistingPivot($this->selectedCoupons, ['status' => 1]);
        $this->record->coupons()->updateExistingPivot($deselectedCoupons, ['status' => 0]);

        $this->record->update(['status' => AircraftLocationPilotStatus::Finalized]);

        Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
            ->send();
    }



}
