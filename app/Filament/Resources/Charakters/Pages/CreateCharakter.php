<?php

namespace App\Filament\Resources\Charakters\Pages;

use App\Filament\Resources\Charakters\CharakterResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCharakter extends CreateRecord
{
    protected static string $resource = CharakterResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
