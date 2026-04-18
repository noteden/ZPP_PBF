<?php

namespace App\Filament\Resources\Charakters\Pages;

use App\Filament\Resources\Charakters\CharakterResource;
use App\Filament\Traits\HasMythicTable;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCharakters extends ListRecords
{
    use HasMythicTable;

    protected static string $resource = CharakterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New Character'),
        ];
    }
}
