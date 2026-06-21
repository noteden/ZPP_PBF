<?php

namespace App\Filament\Widgets;

use App\Models\Thread;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TrendingThreadsWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Popularne wątki';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Thread::query()
                    ->withCount('posts')
                    ->where('archived', false)
                    ->orderByDesc('posts_count')
                    ->limit(5)
            )
            ->paginated(false)
            ->columns([
                TextColumn::make('name')
                    ->label('Wątek')
                    ->limit(50)
                    ->icon('heroicon-m-chat-bubble-left'),

                TextColumn::make('user.name')
                    ->label('Założyciel')
                    ->color('gray'),

                TextColumn::make('posts_count')
                    ->label('Posty')
                    ->badge()
                    ->color('primary'),
            ]);
    }
}
