<?php

namespace App\Filament\Resources\Threads\Pages;

use App\Filament\Resources\Threads\ThreadResource;
use App\Filament\Traits\HasMythicTable;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListThreads extends ListRecords
{
    use HasMythicTable;

    protected static string $resource = ThreadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
