<?php

namespace App\Filament\Resources\PostReports\Pages;

use App\Filament\Resources\PostReports\PostReportResource;
use App\Filament\Traits\HasMythicTable;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPostReports extends ListRecords
{
    use HasMythicTable;

    protected static string $resource = PostReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
