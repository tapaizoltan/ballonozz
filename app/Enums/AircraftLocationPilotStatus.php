<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum AircraftLocationPilotStatus: string implements HasColor, HasIcon, HasLabel
{
    case Draft = "0"; //tervezett
    case Published = "1"; //publikált
    case Closed = "2"; //lezárt
    case Executed = "3"; //végrehajtott
    case Deleted = "4"; //törölt

    public function getLabel(): string
    {
        return match ($this) {
            self::Draft => 'Tervezett',
            self::Published => 'Publikált',
            self::Closed => 'Lezárt',
            self::Executed => 'Végrehajtott',
            self::Deleted => 'Törölt',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Draft => 'warning',
            self::Published => 'success',
            self::Closed => 'warning',
            self::Executed => 'info',
            self::Deleted => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Draft => 'tabler-player-pause',
            self::Published => 'tabler-player-play',
            self::Closed => 'tabler-player-play',
            self::Executed => 'tabler-player-stop',
            self::Deleted => 'tabler-playstation-x',
        };
    }
}