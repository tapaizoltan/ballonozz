<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum CouponStatus: string implements HasColor, HasIcon, HasLabel
{
    case UnderProcess = "0"; //feldolgozás alatt
    case CanBeUsed = "1"; //felhasználható
    case Gift = "2"; //ajándék
    case Used = "3"; //felhasznált
    
    public function getLabel(): string
    {
        return match ($this) {
            self::UnderProcess => 'Feldolgozás alatt',
            self::CanBeUsed => 'Felhasználható',
            self::Gift => 'Ajándék',
            self::Used => 'Felhasznált',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::UnderProcess => 'warning',
            self::CanBeUsed => 'success',
            self::Gift => 'info',
            self::Used => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::UnderProcess => 'tabler-progress-check',
            self::CanBeUsed => 'tabler-discount-check',
            self::Gift => 'tabler-gift',   
            self::Used => 'tabler-circle-x',
        };
    }
}