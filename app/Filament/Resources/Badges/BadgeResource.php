<?php

namespace App\Filament\Resources\Badges;

use App\Models\Badge;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class BadgeResource extends Resource
{
    protected static ?string $model = Badge::class;
    protected static ?string $slug = 'badges';
    protected static ?string $modelLabel = 'Odznaka';
    protected static ?string $pluralModelLabel = 'Odznaki';
    protected static string | \UnitEnum | null $navigationGroup = 'Rozgrywka';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('icon')
                    ->helperText('Format: heroicon-o-badge-check lub nazwa klasy CSS'),

                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('users_count')->counts('users'),
            ]);
    }

    public static function getGlobalSearchEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getGlobalSearchEloquentQuery()->withCount('users');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBadges::route('/'),
            'create' => Pages\CreateBadge::route('/create'),
            'edit' => Pages\EditBadge::route('/{record}/edit'),
        ];
    }
}
