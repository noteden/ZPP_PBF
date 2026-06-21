<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                IconColumn::make('approved')
                    ->label('Zatwierdzony')
                    ->boolean(),
            ])
            ->filters([
                TernaryFilter::make('approved')
                    ->label('Zatwierdzenie')
                    ->placeholder('Wszyscy')
                    ->trueLabel('Zatwierdzeni')
                    ->falseLabel('Oczekujący'),
            ])
            ->bulkActions([])
            ->recordActions([
                Action::make('approve')
                    ->label('Zatwierdź')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn (User $record): bool => ! $record->approved)
                    ->requiresConfirmation()
                    ->action(fn (User $record) => $record->update(['approved' => true])),
                EditAction::make(),
            ]);
    }
}
