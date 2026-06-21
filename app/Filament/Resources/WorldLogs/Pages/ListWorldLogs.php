<?php

namespace App\Filament\Resources\WorldLogs\Pages;

use App\Filament\Resources\WorldLogs\WorldLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWorldLogs extends ListRecords
{
    protected static string $resource = WorldLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
