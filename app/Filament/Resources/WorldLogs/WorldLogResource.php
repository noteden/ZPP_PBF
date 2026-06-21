<?php

namespace App\Filament\Resources\WorldLogs;

use App\Filament\Resources\WorldLogs\Pages;
use App\Models\WorldLog;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WorldLogResource extends Resource
{
    protected static ?string $model = WorldLog::class;

    protected static ?string $slug = 'world-logs';

    protected static ?string $modelLabel = 'Kronika świata';

    protected static ?string $pluralModelLabel = 'Kroniki świata';

    protected static string | \UnitEnum | null $navigationGroup = 'Rozgrywka';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Tytuł')
                    ->required(),

                MarkdownEditor::make('body')
                    ->label('Treść')
                    ->required(),

                DatePicker::make('occurred_on')
                    ->label('Data wydarzenia'),

                Select::make('user_id')
                    ->label('Autor')
                    ->relationship('user', 'name')
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Tytuł')
                    ->searchable(),
                TextColumn::make('occurred_on')
                    ->label('Data')
                    ->date()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Autor'),
            ])
            ->defaultSort('occurred_on', 'desc')
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListWorldLogs::route('/'),
            'create' => Pages\CreateWorldLog::route('/create'),
            'edit'   => Pages\EditWorldLog::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title'];
    }
}
