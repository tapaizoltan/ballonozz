<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum CouponStatus: string implements HasColor, HasIcon, HasLabel
{
    case CanBeUsed = "0"; //felhasználható
    case UnderProcess = "1"; //feldolgozás alatt
    case Used = "2"; //felhasznált
    case Gift = "3"; //ajándék

    public function getLabel(): string
    {
        return match ($this) {
            self::CanBeUsed => 'Felhasználható',
            self::UnderProcess => 'Feldolgozás alatt',
            self::Used => 'Felhasznált',
            self::Gift => 'Ajándék',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::CanBeUsed => 'success',
            self::UnderProcess => 'warning',
            self::Used => 'danger',
            self::Gift => 'info',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::CanBeUsed => 'tabler-discount-check',
            self::UnderProcess => 'tabler-progress-check',
            self::Used => 'tabler-circle-x',
            self::Gift => 'tabler-gift',   
        };
    }
}