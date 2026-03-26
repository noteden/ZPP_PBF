<?php

namespace App\Filament\Resources\Charakters\Pages;

use App\Filament\Resources\Charakters\CharakterResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCharakter extends EditRecord
{
    protected static string $resource = CharakterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
