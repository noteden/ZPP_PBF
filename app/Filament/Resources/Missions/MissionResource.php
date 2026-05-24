<?php

namespace App\Filament\Resources\Missions;

use App\Models\Mission;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MissionResource extends Resource
{
    protected static ?string $model = Mission::class;

    protected static ?string $slug = 'missions';


    protected static string | \UnitEnum | null $navigationGroup = 'Gameplay';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),

                TextInput::make('description')
                    ->required(),

                TextEntry::make('created_at')
                    ->label('Created Date')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->label('Last Modified Date')
                    ->dateTime(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->content(fn ($records) => view('filament.resources.common.mythic-table', [
                'records' => $records,
                'headers' => [
                    ['label' => 'MISSION NAME', 'field' => 'name', 'width' => 'col-span-12 md:col-span-5', 'icon' => 'flag_circle'],
                    ['label' => 'DESCRIPTION', 'field' => 'description', 'width' => 'col-span-12 md:col-span-7'],
                ]
            ]))
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMissions::route('/'),
            'create' => Pages\CreateMission::route('/create'),
            'edit' => Pages\EditMission::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
