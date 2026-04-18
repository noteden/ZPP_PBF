<?php

namespace App\Filament\Widgets;

use App\Models\CharakterSheet;
use App\Models\Mission;
use App\Models\Post;
use App\Models\User;
use Filament\Widgets\Widget;

class ProjectStatsWidget extends Widget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = [
        'md' => 12,
        'lg' => 4,
    ];

    protected string $view = 'filament.widgets.project-stats-widget';

    protected function getViewData(): array
    {
        return [
            'usersCount' => User::count(),
            'missionsCount' => Mission::count(),
            'postsCount' => Post::count(),
            'charakterSheetsCount' => CharakterSheet::count(),
        ];
    }
}
