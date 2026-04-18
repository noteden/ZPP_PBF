<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class QuickActionsWidget extends Widget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = [
        'md' => 12,
        'lg' => 4,
    ];

    protected string $view = 'filament.widgets.quick-actions-widget';
}
