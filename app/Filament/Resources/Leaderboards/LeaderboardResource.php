<?php

namespace App\Filament\Resources\Leaderboards;

use App\Filament\Resources\Leaderboards\Pages;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class LeaderboardResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationLabel = 'Leaderboard';
    protected static ?string $pluralModelLabel = 'Leaderboard';
    protected static string | \UnitEnum | null $navigationGroup = 'Gameplay';

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->withCount(['posts', 'badges', 'sentMessages'])
            )
            ->columns([
                TextColumn::make('index')
                    ->label('Miejsce')
                    ->rowIndex(),

                TextColumn::make('name')
                    ->label('Użytkownik')
                    ->searchable(),

                TextColumn::make('posts_count')
                    ->label('Posty')
                    ->sortable(),

                TextColumn::make('badges_count')
                    ->label('Odznaki')
                    ->sortable(),

                TextColumn::make('sent_messages_count')
                    ->label('Wiadomości')
                    ->sortable(),

                TextColumn::make('total_score')
                    ->label('Suma Punktów')
                    ->weight('bold')
                    ->color('success')
                    ->state(fn ($record) => $record->posts_count + $record->badges_count + $record->sent_messages_count)
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->orderByRaw('(posts_count + badges_count + sent_messages_count) ' . $direction);
                    }),
            ])
            ->defaultSort(fn ($query) => $query->orderByRaw('(posts_count + badges_count + sent_messages_count) DESC'))
            ->filters([])
            ->actions([])
            ->bulkActions([]);


    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeaderboards::route('/'),
        ];
    }

    public static function canCreate(): bool { return false; }
}
