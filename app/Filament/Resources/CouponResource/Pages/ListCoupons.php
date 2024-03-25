<?php

namespace App\Filament\Resources\CouponResource\Pages;

use Filament\Actions;
use App\Enums\CouponStatus;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CouponResource;

class ListCoupons extends ListRecords
{
    protected static string $resource = CouponResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('Mind'),
            'Figyelmeztetések' => Tab::make()->query(
                function($record)
                {
                    $coupon_total_passenger_nums = $record->adult + $record->children;
                    $coupon_registered_passeger_nums = $record->passengers->count();
                    dd($coupon_total_passenger_nums);

                    if ($coupon_total_passenger_nums != $coupon_registered_passeger_nums && $record->status != CouponStatus::Used && $record->status != CouponStatus::UnderProcess)
                    {

                    }
                })
                ->icon('tabler-alert-triangle')
                ->badgeColor('danger'),
            'Feldolgozás alatt' => Tab::make()->query(fn ($query) => $query->where('status', '0'))->icon('tabler-progress-check')->badgeColor('warning'),
            'Felhasználható' => Tab::make()->query(fn ($query) => $query->where('status', '1')->orwhere('status', '2'))->icon('tabler-discount-check')->badgeColor('success'),
            'Felhasznált' => Tab::make()->query(fn ($query) => $query->where('status', '3'))->icon('tabler-circle-x')->badgeColor('danger'),
        ];
    }
}
