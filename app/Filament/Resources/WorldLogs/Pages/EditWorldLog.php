<?php

namespace App\Filament\Resources\WorldLogs\Pages;

use App\Filament\Resources\WorldLogs\WorldLogResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWorldLog extends EditRecord
{
    protected static string $resource = WorldLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
