<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum AircraftType: string implements HasColor, HasIcon, HasLabel
{
    case Ballon = "0";
    case Airplane = "1";
    case Rocket = "2";

    /*
    case New = 'new';

    case Processing = 'processing';

    case Shipped = 'shipped';

    case Delivered = 'delivered';

    case Cancelled = 'cancelled';
*/
    public function getLabel(): string
    {
        return match ($this) {
            self::Ballon => 'Hőlégballon',
            self::Airplane => 'Kisrepülőgép',
            self::Rocket => 'Űrrakéta',
            /*
            self::Shipped => 'Shipped',
            self::Delivered => 'Delivered',
            self::Cancelled => 'Cancelled',
            */
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Ballon => 'gray',
            self::Airplane => 'gray',
            self::Rocket => 'gray',
            /*
            self::New => 'info',
            self::Processing => 'warning',
            self::Shipped, self::Delivered => 'success',
            self::Cancelled => 'danger',
            */
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Ballon => 'iconoir-hot-air-balloon',
            self::Airplane => 'iconoir-airplane',
            self::Rocket => 'iconoir-rocket',
            /*
            self::New => 'heroicon-m-sparkles',
            self::Processing => 'heroicon-m-arrow-path',
            self::Shipped => 'heroicon-m-truck',
            self::Delivered => 'heroicon-m-check-badge',
            self::Cancelled => 'heroicon-m-x-circle',
            */
        };
    }
}