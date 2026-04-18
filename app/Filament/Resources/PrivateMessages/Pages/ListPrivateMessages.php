<?php

namespace App\Filament\Resources\PrivateMessages\Pages;

use App\Filament\Resources\PrivateMessages\PrivateMessageResource;
use App\Filament\Traits\HasMythicTable;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPrivateMessages extends ListRecords
{
    use HasMythicTable;

    protected static string $resource = PrivateMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
