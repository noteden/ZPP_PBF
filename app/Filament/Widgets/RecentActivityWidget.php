<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentActivityWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Ostatnia aktywność';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Post::query()
                    ->with(['user', 'thread', 'charakter'])
                    ->latest()
                    ->limit(5)
            )
            ->paginated(false)
            ->columns([
                TextColumn::make('charakter.name')
                    ->label('Autor')
                    ->default('—')
                    ->description(fn (Post $record): ?string => $record->user?->name)
                    ->icon('heroicon-m-user'),

                TextColumn::make('thread.name')
                    ->label('Wątek')
                    ->limit(40)
                    ->color('gray'),

                TextColumn::make('content')
                    ->label('Treść')
                    ->limit(60)
                    ->color('gray'),

                TextColumn::make('created_at')
                    ->label('Kiedy')
                    ->since()
                    ->badge()
                    ->color('primary'),
            ]);
    }
}
