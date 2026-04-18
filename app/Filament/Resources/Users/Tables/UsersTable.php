<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->content(fn ($records) => view('filament.resources.common.mythic-table', [
                'records' => $records,
                'headers' => [
                    ['label' => 'USER', 'field' => 'name', 'subfield' => 'email', 'width' => 'col-span-12 md:col-span-6', 'icon' => 'person'],
                    ['label' => 'VERIFIED AT', 'field' => 'email_verified_at', 'width' => 'col-span-12 md:col-span-3'],
                    ['label' => 'JOINED', 'field' => 'created_at', 'width' => 'col-span-12 md:col-span-3'],
                ]
            ]))
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->bulkActions([])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
