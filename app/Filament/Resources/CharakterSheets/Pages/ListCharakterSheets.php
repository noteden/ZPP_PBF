<?php

namespace App\Filament\Resources\CharakterSheets\Pages;

use App\Filament\Resources\CharakterSheets\CharakterSheetResource;
use App\Filament\Traits\HasMythicTable;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCharakterSheets extends ListRecords
{
    use HasMythicTable;

    protected static string $resource = CharakterSheetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
