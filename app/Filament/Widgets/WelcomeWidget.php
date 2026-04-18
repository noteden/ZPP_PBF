<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class WelcomeWidget extends Widget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = [
        'md' => 12,
        'lg' => 8,
    ];

    protected string $view = 'filament.widgets.welcome-widget';
}
