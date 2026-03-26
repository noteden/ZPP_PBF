<?php

namespace App\Filament\Resources\PostReports\Pages;

use App\Filament\Resources\PostReports\PostReportResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePostReport extends CreateRecord
{
    protected static string $resource = PostReportResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
