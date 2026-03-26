<?php

namespace App\Filament\Resources\CharakterSheets\Pages;

use App\Filament\Resources\CharakterSheets\CharakterSheetResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCharakterSheet extends CreateRecord
{
    protected static string $resource = CharakterSheetResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
