<?php

namespace App\Filament\Resources\CharakterSheets\Pages;

use App\Filament\Resources\CharakterSheets\CharakterSheetResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCharakterSheet extends EditRecord
{
    protected static string $resource = CharakterSheetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
