<?php

namespace App\Filament\Widgets;

use App\Models\Thread;
use Filament\Widgets\Widget;

class TrendingThreadsWidget extends Widget
{
    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = [
        'md' => 12,
        'lg' => 4,
    ];

    protected string $view = 'filament.widgets.trending-threads-widget';

    public function getTrending()
    {
        return Thread::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->limit(3)
            ->get();
    }
}
