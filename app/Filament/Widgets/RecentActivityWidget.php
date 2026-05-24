<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\Widget;

class RecentActivityWidget extends Widget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = [
        'md' => 12,
        'lg' => 8,
    ];

    protected string $view = 'filament.widgets.recent-activity-widget';

    public function getActivities()
    {
        return Post::with(['user', 'thread', 'charakter'])
            ->latest()
            ->limit(4)
            ->get();
    }
}
