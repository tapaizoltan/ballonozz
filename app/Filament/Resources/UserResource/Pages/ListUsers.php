<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Tables\Columns\Column;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
