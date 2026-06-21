<?php

namespace App\Filament\Widgets;

use App\Models\Charakter;
use App\Models\CharakterSheet;
use App\Models\Mission;
use App\Models\Post;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProjectStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        return [
            Stat::make('Gracze', User::count())
                ->description('Zarejestrowani użytkownicy')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Postacie', Charakter::count())
                ->description(CharakterSheet::count().' kart postaci')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),

            Stat::make('Posty', Post::count())
                ->description('Wpisy na forum')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('info'),

            Stat::make('Misje', Mission::count())
                ->description('Zgłoszone misje')
                ->descriptionIcon('heroicon-m-map')
                ->color('warning'),
        ];
    }
}
