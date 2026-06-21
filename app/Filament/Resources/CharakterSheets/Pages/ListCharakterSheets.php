<?php

namespace App\Filament\Resources\CharakterSheets\Pages;

use App\Filament\Resources\CharakterSheets\CharakterSheetResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCharakterSheets extends ListRecords
{
    protected static string $resource = CharakterSheetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
