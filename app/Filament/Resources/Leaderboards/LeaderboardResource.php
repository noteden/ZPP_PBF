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
    protected static ?string $navigationLabel = 'Ranking';
    protected static ?string $modelLabel = 'Ranking';
    protected static ?string $pluralModelLabel = 'Ranking';
    protected static string | \UnitEnum | null $navigationGroup = 'Rozgrywka';

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
                        return $query->orderByRaw(self::scoreExpression() . ' ' . $direction);
                    }),
            ])
            ->defaultSort(fn ($query) => $query->orderByRaw(self::scoreExpression() . ' DESC'))
            ->filters([])
            ->actions([])
            ->bulkActions([]);


    }

    /**
     * Suma punktów liczona korelowanymi podzapytaniami — kompatybilne z PostgreSQL
     * (aliasów z withCount nie można użyć wewnątrz wyrażenia ORDER BY).
     */
    protected static function scoreExpression(): string
    {
        return '('
            . '(select count(*) from posts where posts.user_id = users.id)'
            . ' + (select count(*) from badge_user where badge_user.user_id = users.id)'
            . ' + (select count(*) from private_messages where private_messages.sender_user_id = users.id)'
            . ')';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeaderboards::route('/'),
        ];
    }

    public static function canCreate(): bool { return false; }
}
