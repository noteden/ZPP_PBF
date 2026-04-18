<?php

namespace App\Filament\Resources\Tutorials\Pages;

use App\Filament\Resources\Tutorials\TutorialResource;
use App\Filament\Traits\HasMythicTable;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTutorials extends ListRecords
{
    use HasMythicTable;

    protected static string $resource = TutorialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
