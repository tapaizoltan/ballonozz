<?php

namespace App\Filament\Resources\CouponResource\Pages;

use App\Filament\Resources\CouponResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

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
            'Felhasználható' => Tab::make()->query(fn ($query) => $query->where('status', '0')->orwhere('status', '4'))->icon('tabler-discount-check')->badgeColor('success'),
            'Feldolgozás alatt' => Tab::make()->query(fn ($query) => $query->where('status', '1'))->icon('tabler-progress-check')->badgeColor('warning'),
            'Felhasznált' => Tab::make()->query(fn ($query) => $query->where('status', '2'))->icon('tabler-circle-x')->badgeColor('danger'),
        ];
    }
}
