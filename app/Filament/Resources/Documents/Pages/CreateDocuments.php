<?php

namespace App\Filament\Resources\Documents\Pages;

use App\Filament\Resources\Documents\DocumentsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDocuments extends CreateRecord
{
    protected static string $resource = DocumentsResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
