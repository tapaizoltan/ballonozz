<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum AircraftLocationPilotStatus: string implements HasColor, HasIcon, HasLabel
{
    case Draft = "0"; //tervezett
    case Published = "1"; //publikált
    case Executed = "2"; //végrehajtott
    case Deleted = "3"; //törölt

    public function getLabel(): string
    {
        return match ($this) {
            self::Draft => 'Tervezett',
            self::Published => 'Publikált',
            self::Executed => 'Végrehajtott',
            self::Deleted => 'Törölt',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Draft => 'warning',
            self::Published => 'success',
            self::Executed => 'info',
            self::Deleted => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Draft => 'tabler-player-pause',
            self::Published => 'tabler-player-play',
            self::Executed => 'tabler-player-stop',
            self::Deleted => 'tabler-playstation-x',
        };
    }
}