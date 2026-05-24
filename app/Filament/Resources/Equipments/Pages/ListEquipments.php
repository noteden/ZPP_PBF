<?php

namespace App\Filament\Resources\Equipments\Pages;

use App\Filament\Resources\Equipments\EquipmentResource;
use App\Filament\Traits\HasMythicTable;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEquipments extends ListRecords
{
    use HasMythicTable;

    protected static string $resource = EquipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
